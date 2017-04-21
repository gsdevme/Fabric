<?php declare(strict_types=1);

namespace Gsdev\Fabric\Test\Client;

use Gsdev\Fabric\Client\ClientValidationTrait;
use Gsdev\Fabric\Model\Exception\InvalidResponseDataException;
use Gsdev\Fabric\Model\Request\RequestInterface;
use Gsdev\Fabric\Model\Request\ValidateResponseDataRequestInterface;
use Gsdev\Fabric\Model\Validator\ValidatorInterface;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery;

class ClientValidationTraitTest extends MockeryTestCase
{
    /**
     * @var ClientValidationTrait
     */
    private $client;

    public function setUp()
    {
        $this->client = new class() {
            use ClientValidationTrait;
        };
    }

    public function testValidatorIsNotCalledWhenInterfaceIsNotImplemented()
    {
        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class);
        $request->shouldNotReceive('getValidator');

        $this->client->doValidation($request, []);
    }

    public function testValidatorIsCalledWhenImplemented()
    {
        $validator = Mockery::mock(ValidatorInterface::class);
        $validator->shouldReceive('isValidResponseData')->andReturn(true);

        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class, ValidateResponseDataRequestInterface::class);
        $request->shouldReceive('getValidator')->andReturn($validator);

        $this->client->doValidation($request, []);
    }

    public function testValidatorIsCalledWhenImplementedAndException()
    {
        $validator = Mockery::mock(ValidatorInterface::class);
        $validator->shouldReceive('isValidResponseData')->andReturn(false);

        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class, ValidateResponseDataRequestInterface::class);
        $request->shouldReceive('getValidator')->andReturn($validator);

        $this->expectException(InvalidResponseDataException::class);

        $this->client->doValidation($request, []);
    }
}
