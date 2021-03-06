Api Platform Bundle
===================

[![Latest Stable Version](https://poser.pugx.org/marfatech/api-platform-bundle/v/stable)](https://packagist.org/packages/marfatech/api-platform-bundle)
[![Total Downloads](https://poser.pugx.org/marfatech/api-platform-bundle/downloads)](https://packagist.org/packages/marfatech/api-platform-bundle)

Введение
--------

Бандл расширяет компонет Symfony [http-foundation](https://github.com/symfony/http-foundation) позволя выделить
работу с API в отдельную инкапсулированную зону. 

Предоставляется работа с контентом запроса в формате `JSON` посредством `ParameterBag`.
Архитектура бандла не допускает фатального падения в зоне API и всегда возвращает валидный ответ
с соответствующим кодом ошибки. Полный список кодов ошибок доступен в виде констант в классе
[ApiException](./Exception/ApiException.php).

Для описания спецификации API рекомендуется использование
[OpenApi 3](https://github.com/OAI/OpenAPI-Specification/blob/main/versions/3.0.0.md) совместно с [swagger-resolver-bundle](https://github.com/marfatech/swagger-resolver-bundle)
в одном из форматов:
- [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle).
- [swagger-php](https://github.com/zircote/swagger-php).
- Использование файла конфигурации в формате `json` или `yaml` (`yml`).

Установка
---------

### Шаг 1: Загрузка бандла

Откройте консоль и, перейдя в директорию проекта, выполните следующую команду для загрузки наиболее подходящей
стабильной версии этого бандла:
```bash
    composer require marfatech/api-platform-bundle
```
*Эта команда подразумевает что [Composer](https://getcomposer.org) установлен и доступен глобально.*

### Шаг 2: Подключение бандла

После включите бандл добавив его в список зарегистрированных бандлов в `app/AppKernel.php` файл вашего проекта:

```php
<?php declare(strict_types=1);
// app/AppKernel.php

class AppKernel extends Kernel
{
    // ...

    public function registerBundles()
    {
        $bundles = [
            // ...

            new MarfaTech\Bundle\ApiPlatformBundle\MarfaTechApiPlatformBundle(),
        ];

        return $bundles;
    }

    // ...
}
```

Конфигурация
------------

Чтобы начать использовать бандл, требуется определить создать и определить `guesser` - объект содержащий правила
определения зоны API вашего проекта.

```php
<?php

declare(strict_types=1);

namespace App\Guesser\ApiAreaGuesser;

use Symfony\Component\HttpFoundation\Request;
use MarfaTech\Bundle\ApiPlatformBundle\Guesser\ApiAreaGuesserInterface;

class ApiAreaGuesser implements ApiAreaGuesserInterface
{
    /**
     * {@inheritDoc}
     */
    public function getApiVersion(Request $request): ?int
    {
        $apiVersionMatch = [];
        preg_match('/^\/v([\d]+)\//i', $request->getPathInfo(), $apiVersionMatch);

        if (empty($apiVersionMatch)) {
            return null;
        }

        $apiVersion = (int) end($apiVersionMatch);

        return $apiVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function isApiRequest(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api') === 0;
    }
}
```

**Примечание:** Если вы не используете `autowire` то вам необходимо зарегистрировать `ApiAreaGuesser` как сервис.

```yaml
# config/packages/marfa_tech_api_platform.yaml
marfa_tech_api_platform:
    api_area_guesser_service:   App\Guesser\ApiAreaGuesser
```

### Полный набор параметров

```yaml
# config/packages/marfa_tech_api_platform.yaml
marfa_tech_api_platform:
    # полное имя класса DTO для стандартизации ответа
    api_result_dto_class:       MarfaTech\Bundle\ApiPlatformBundle\Dto\ApiResultDto

    # идентификатор сервиса для определения зоны API
    api_area_guesser_service:   App\Guesser\ApiAreaGuesser

    # идентификатор сервиса для глобального отлавливания ошибок и выдачи специализированных сообщений вместо 500
    error_code_guesser_service: MarfaTech\Bundle\ApiPlatformBundle\Guesser\ApiErrorCodeGuesser

    # Минимально допустимая версия API.
    minimal_api_version:        1

    # флаг для отладки ошибок - если установлен в true - ответ ошибки содержит trace.
    response_debug:             false
```

Использование
-------------

Использование функционала бандла начинается с создания контроллера и первого метода в указанной зоне API.
В качестве примера рассмотрим возвращение простейшего профиля пользователя.

Для начала нам необходимо создать DTO возвращаемых данных:

```php
<?php declare(strict_types=1);

namespace App\Dto;

use OpenApi\Annotations as OA;
use MarfaTech\Component\DtoResolver\Dto\DtoResolverTrait;
use MarfaTech\Component\DtoResolver\Dto\DtoResolverInterface;

/**
 * @OA\Schema(
 *      type="object",
 *      description="Profile info",
 *      required={"email", "firstName", "lastName"},
 * )
 */
class ProfileResultDto implements DtoResolverInterface
{
    use DtoResolverTrait;
    
    /**
     * @OA\Property(description="Profile email", example="test@gmail.com")
     */
    protected string $email;

    /**
     * @OA\Property(description="User's first name", example="John")
     */
    protected string $firstName;

    /**
     * @OA\Property(description="User's last name", example="Doe")
     */
    protected string $lastName;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
```

Теперь добавим контроллер с соответствующим методом.
**Примечание:** в качестве примера реализации используется подключение
[NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle).

```php
<?php declare(strict_types=1);

namespace App\Controller;

use App\Dto\ProfileResultDto;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\ApiDtoFactory;
use MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiResponse;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\ApiDtoResolverFactoryInterface;

/**
 * @Route("/api/profile")
 */
class ProfileController
{
    /**
     * Returns user profile
     *
     * @Route(methods={"GET"})
     *
     * @OA\Response(
     *      response=ApiResponse::HTTP_OK,
     *      description="Successful result in 'data' offset",
     *      @Model(type=ProfileResultDto::class),
     *      
     * )
     */
    public function getProfile(ApiDtoResolverFactoryInterface $factory): ApiResponse
    {
        // обработка данных

        $resultDto = $factory->createApiDto(ProfileResultDto::class, [
            'email' => 'test-user@mail.ru',
            'firstName' => 'Test',
            'lastName' => 'User',
        ]);

        return new ApiResponse($resultDto);
    }
}
```

Дополнительно
-------------

### Как комбинировать body параметры с query и/или path 

Объект на DTO:

```php
<?php declare(strict_types=1);

namespace App\Dto;

use OpenApi\Annotations as OA;
use MarfaTech\Bundle\ApiPlatformBundle\Dto\MagicAwareDtoResolverTrait;
use MarfaTech\Component\DtoResolver\Dto\DtoResolverInterface;

/**
 * @OA\Schema(
 *      type="object",
 *      description="Update profile info",
 *      required={"firstName", "lastName"},
 * )
 * 
 * @method getEmail(): string
 */
class UpdateProfileEntryDto implements DtoResolverInterface
{
    use MagicAwareDtoResolverTrait;
    
    protected string $email;

    /**
     * @OA\Property(description="User's first name", example="John")
     */
    protected string $firstName;

    /**
     * @OA\Property(description="User's last name", example="Doe")
     */
    protected string $lastName;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
```

Контроллер:

```php
<?php declare(strict_types=1);

namespace App\Controller;

use App\Dto\UpdateProfileEntryDto;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;
use MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiResponse;

/**
 * @Route("/api/profile")
 */
class ProfileController
{
    /**
     * Update user password
     *
     * @Route("/{email}", methods={"PATCH"})
     *
     * @OA\Parameter(name="email", in="path", @OA\Schema(type="string"), required=true, description="User email")
     * @OA\RequestBody(required=true, @Model(type=UpdateProfileEntryDto::class))
     */
    public function getProfile(UpdateProfileEntryDto $entryDto): ApiResponse
    {
        return new ApiResponse($entryDto);
    }
}
```

### Как описать в формат обертки ответа в аннотациях

Чтобы описать формат обертки ответа `MarfaTech\Bundle\ApiPlatformBundle\Dto\ApiResultDto` при помощи аннотаций
можно использовать следующий подход:

**Шаг 1** Создайте собственный ответ сервера:

```php
<?php declare(strict_types=1);

namespace App\Dto;

use OpenApi\Annotations as OA;
use MarfaTech\Bundle\ApiPlatformBundle\Dto\ApiResultDto as BaseApiResultDto;
use MarfaTech\Component\DtoResolver\Dto\DtoResolverInterface;

/**
 * @OA\Schema(
 *      type="object",
 *      description="Common API response object template",
 *      required={"code", "message"},
 * )
 */
class ApiResultDto extends BaseApiResultDto
{
    /**
     * @var int
     *
     * @OA\Property(description="Response api code", example=0, default=0)
     */
    protected $code = 0;

    /**
     * @var string
     *
     * @OA\Property(description="Localized human readable text", example="Successfully")
     */
    protected $message;

    /**
     * @var DtoResolverInterface|null
     *
     * @OA\Property(type="object", description="Some specific response data or null")
     */
    protected $data = null;
}

```

**Шаг 2** Добавьте в конфигурацию:

```yaml
# config/packages/marfa_tech_api_platform.yaml
marfa_tech_api_platform:
    api_result_dto_class:       App\Dto\MyApiResultDto
```

**Шаг 3** Добавьте описание к вашему методу:

```php
<?php declare(strict_types=1);

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiRequest;
use MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiResponse;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\ApiDtoFactory;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\ApiDtoResolverFactoryInterface;

class ProfileController
{
    /**
     * ...
     * 
     * @OA\Parameter(name="username", in="query", @OA\Schema(type="string"), required=true, description="User login")
     * @OA\Response(
     *      response=ApiResponse::HTTP_OK,
     *      description="Successful result in 'data' offset",
     *      @Model(type=ProfileResultDto::class),
     * )
     * @OA\Response(response="default", @Model(type=ApiResultDto::class), description="Response wrapper")
     */
    public function getProfile(ApiRequest $apiRequest, ApiDtoResolverFactoryInterface $factory): ApiResponse
    {
        return new ApiResponse();
    }
}
```

Лицензия
--------

[![license](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](./LICENSE)
