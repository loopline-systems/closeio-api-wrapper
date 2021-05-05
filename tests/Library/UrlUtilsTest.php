<?php

 declare(strict_types=1);

 namespace Tests\LooplineSystems\CloseIoApiWrapper\Library;

 use LooplineSystems\CloseIoApiWrapper\Library\UrlUtils;
 use PHPUnit\Framework\TestCase;

 final class UrlUtilsTest extends TestCase
 {
     /**
      * @dataProvider provideUrl
      */
     public function testValidate(bool $isValid, string $url): void
     {
         $this->assertSame($isValid, UrlUtils::validate($url));
     }

     public function provideUrl(): \Generator
     {
         yield [true, "https://www.example.com"];

         yield [true, "https://www.example.com/foo/bar/baz"];

         yield [true, "https://www.example.com/foo/bär/bäz"];

         yield [true, "https://www.exämple.com"];

         yield [true, "https://www.exämple.com/foo/bär/bäz"];

         yield [true, "https://www.🚀.com"];
     }
 }
