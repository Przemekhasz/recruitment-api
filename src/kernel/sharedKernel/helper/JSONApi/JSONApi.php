<?php

declare(strict_types=1);

namespace App\kernel\sharedKernel\helper\JSONApi;

use App\kernel\sharedKernel\helper\JSONApi\dto\JSONApiResponseSchema;
use DateTimeInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use JetBrains\PhpStorm\Pure;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class JSONApi
{

    /**
     * @var JSONApiResponseSchema
     */
    private JSONApiResponseSchema $schema;

    private array $defaultIgnoredFields = [
        'lazyPropertiesNames', 'lazyPropertiesDefaults',
        '__cloner__', '__initializer__', '__is_initialized__'
    ];

    /**
     * @param string $type
     */
    #[Pure] public function __construct(string $type)
    {

        $this->schema = new JSONApiResponseSchema();
        $this->schema->type = $type;
        $this->schema->ignore = $this->defaultIgnoredFields;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self {
        $this->schema->type = $type;
        return $this;
    }

    /**
     * @param        $object
     * @param string $message
     * @param int $status
     * @param array $groups
     * @return JsonResponse
     */
    public function toJSON($object, string $message = '', int $status = 200, array $groups = []): JsonResponse
    {

        $this->schema->status = $status;
        $this->schema->message = $message;
        $this->schema->data = $object;
        $this->schema->groups = $groups;

        return $this->buildResponse($this->schema);
    }

    /**
     * @param array $groups
     *
     * @return $this
     */
    public function setGroups(array $groups): self {
        $this->schema->groups = $groups;

        return  $this;
    }

    public function ignoreFields(array $fields): self {
        $this->schema->ignore = $fields;

        return $this;
    }

    /**
     * @param string|Exception $exception
     * @param int              $status
     *
     * @return JsonResponse
     */
    public function throwException(string|Exception $exception, int $status = 500): JsonResponse
    {
        $this->schema->status = $status;

        if ($exception instanceof Exception) {
            $this->schema->message = $exception->getMessage();
        }
        if (is_string($exception)) {
            $this->schema->message = $exception;
        }
        return $this->buildResponse($this->schema);
    }


    /**
     * @param JSONApiResponseSchema $schema
     *
     * @return JsonResponse
     */
    private function buildResponse(JSONApiResponseSchema $schema): JsonResponse {

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
                function ($obj, $format, $context)  {
                    return $obj->getId();
                }
        ];

        if (count($schema->groups) > 0) {
            $defaultContext[AbstractNormalizer::GROUPS] = $schema->groups;
        }

        if (count($schema->ignore) > 0) {
            $defaultContext[AbstractNormalizer::IGNORED_ATTRIBUTES] = $schema->ignore;
        }

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $JsonEncoder = new JsonEncoder();
        $objectNormalizer = new ObjectNormalizer($classMetadataFactory, null, null,
                null, null, null,
                $defaultContext);

        $serializer = new Serializer([$objectNormalizer], [$JsonEncoder]);


        $json = $serializer->serialize( $schema, JsonEncoder::FORMAT);

        $response = new JsonResponse($json, $schema->status, [], true);
        $this->schema->cleanUp();

        return $response;
    }
}
