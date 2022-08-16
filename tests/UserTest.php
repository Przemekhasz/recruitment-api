<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class UserTest extends WebTestCase
{
    public function testSignUp(): void
    {
        $client = static::createClient();

        $body = '{
            "password": "12345678",
            "email": "emaildotestow@gmail.com"
        }';

        $client->request(Request::METHOD_POST, '/api/sign-up', [], [],[], $body);

        $this->assertResponseIsSuccessful();
    }

    public function testSignIn(): void
    {
        $client = static::createClient();

        $body = '{
            "password": "12345678",
            "email": "emaildotestow@gmail.com"
        }';

        $client->request(Request::METHOD_POST, '/api/sign-in', [], [], [], $body);

        $data = (array) json_decode($client->getResponse()->getContent(), true);
        $token = $data['data']['jwt'];
       //dd($token);
        $this->assertResponseIsSuccessful();
    }

    public function testProfile(): void
    {
        $client = static::createClient();

        $body = '{
          "firstName": "Przemek",
          "lastName": "Tarapacki"
        }';

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NjA1OTEyOTMsImV4cCI6MTY2MDU5NDg5Mywicm9sZXMiOltdLCJ1c2VybmFtZSI6ImVtYWlsZG90ZXN0b3dAZ21haWwuY29tIn0.vYZWXwvZG15IYEJNolIKfH2vPdMiHoYqv0p3r40Vhv6LSQzV9ccdC814ZysieiUQTOSS2gOmm0eKTqONmB-qecGQXAlqTMEa_oH9s5byb_y24L0fis-GAjXwFmJMlpjDd5-K7D9_pyDt0WZ8-PNEcdP_6AqeHlITcdc-_Md9MyGPv0BinCDrAlmCn5lEys_g18LfB6lZ24YYh1MzYnU2sC6yvqPbcmovD1eVsc_gxKByTPdbYAihlrphu-rse5m1ZLziGAHwiTAFdohiSoh9ZtYzuUjudMD7l4h-adhhvJTMtmZZ6iPLZjpJD5uE9Is9BFKox56Tk5pQ2Sv4YFXwvA";

        $header = [
            'HTTP_Authorization' => sprintf('%s %s', 'Bearer', $token),
            'HTTP_CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT'       => 'application/json',
        ];

        $client->request(Request::METHOD_POST, '/api/me/profile', [], [], $header, $body);

        //dd($client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
    }


    public function testUploadFile(): void
    {
        $client = static::createClient();

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NjA1OTEyOTMsImV4cCI6MTY2MDU5NDg5Mywicm9sZXMiOltdLCJ1c2VybmFtZSI6ImVtYWlsZG90ZXN0b3dAZ21haWwuY29tIn0.vYZWXwvZG15IYEJNolIKfH2vPdMiHoYqv0p3r40Vhv6LSQzV9ccdC814ZysieiUQTOSS2gOmm0eKTqONmB-qecGQXAlqTMEa_oH9s5byb_y24L0fis-GAjXwFmJMlpjDd5-K7D9_pyDt0WZ8-PNEcdP_6AqeHlITcdc-_Md9MyGPv0BinCDrAlmCn5lEys_g18LfB6lZ24YYh1MzYnU2sC6yvqPbcmovD1eVsc_gxKByTPdbYAihlrphu-rse5m1ZLziGAHwiTAFdohiSoh9ZtYzuUjudMD7l4h-adhhvJTMtmZZ6iPLZjpJD5uE9Is9BFKox56Tk5pQ2Sv4YFXwvA";

        $header = [
            'HTTP_Authorization' => sprintf('%s %s', 'Bearer', $token),
            'HTTP_CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT'       => 'application/json',
        ];

        $uploadedFile = new UploadedFile(
            __DIR__.'/../dirToFile/file.jpg',
            'oryginalName.jpg'
        );

        $client->request(Request::METHOD_POST, '/api/me/upload-file', [], [$uploadedFile], $header);

        //dd($client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
    }
}
