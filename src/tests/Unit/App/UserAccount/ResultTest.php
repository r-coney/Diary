<?php

namespace Tests\Unit\App\UserAccount;

use App\UserAccount\Result;
use Tests\TestCase;

class ResultTest extends TestCase
{
    /**
     * @test
     */
    public function 成功の結果を構築できること(): void
    {
        $returnValueString = 'success';
        $result = Result::ofValue($returnValueString);

        $this->assertFalse($result->hasError());
        $this->assertSame($returnValueString, $result->value());
    }

    /**
     * ;@test
     */
    public function エラーの結果を構築できること(): void
    {
        $returnErrorString = 'error';
        $result = Result::ofError($returnErrorString);

        $this->assertTrue($result->hasError());
        $this->assertSame($returnErrorString, $result->error());
    }
}
