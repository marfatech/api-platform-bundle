## [Unreleased]

## [3.4.0] - 2022-07-21
### Added
- Support versions `>=1.0` of `marfatech/swagger-resolver-bundle`.

## [3.3.2] - 2022-06-15
### Fixed
- Catch `MissingOptionsException` as 4xx http status code while resolve request.

## [3.3.1] - 2022-05-30
### Added
- Conflict with version `>=1.0` of `marfatech/swagger-resolver-bundle`. 

## [3.3.0] - 2022-05-24
### Added
- Symfony 6 support
- Test for `ApiDtoFactory`
## Changed
- Updated `php` with pattern version `~8.0`.
- Updated `symfony/*` with pattern version `~4.4||~5.4||~6.0`.
- Moved `marfatech/swagger-resolver-bundle` from required to suggested

## [3.2.0] - 2022-05-19
### Added
- File `.phpstorm.meta.php` idea friendly.
- Installed `symfony/options-resolver` to the `~3.4||~4.0||~5.0` pattern version.
### Changed
- Factory `MarfaTech\Bundle\ApiPlatformBundle\Factory\ApiDtoFactory` is deprecated, if you need decorate then extend `ApiDtoResolverFactory` and decorate service `marfa_tech_api_platform.factory.api_dto`.
### Removed
- Deleted `marfatech/swagger-resolver-bundle`.

## [3.1.0] - 2022-05-17
## Added
- Handling `Symfony\Component\Validator\Exception\ValidationFailedException` while resolving entryDto if you prefer to use constraints from `symfony/validation`.
- Logging `Throwable` exception while controller argument resolving.
## Changed
- Catch `Throwable` insteadof `Exception` while controller argument resolving.
- Service translator class name alias `Symfony\Component\Translation\TranslatorInterface` change to service id `translator`.

## [3.0.2] - 2021-11-08
## Changed
- Renamed prefix bundle and extension names `Marfatech` to `MarfaTech`.
- Renamed root config `marfatech_api_platform` to `marfa_tech_api_platform`.
- Renamed service `marfatech_api_platform.factory.api_dto` to `marfa_tech_api_platform.factory.api_dto`.
- Renamed parameter `marfatech_api_platform.error_code_guesser_service` to `marfa_tech_api_platform.error_code_guesser_service`.
- Renamed parameter `marfatech_api_platform.response_debug` to `marfa_tech_api_platform.response_debug`.
- Renamed parameter `marfatech_api_platform.api_result_dto_class` to `marfa_tech_api_platform.api_result_dto_class`.
- Renamed parameter `marfatech_api_platform.api_area_guesser_service` to `marfa_tech_api_platform.api_area_guesser_service`.
- Renamed parameter `marfatech_api_platform.error_code_guesser_service` to `marfa_tech_api_platform.error_code_guesser_service`.
- Renamed parameter `marfatech_api_platform.minimal_api_version` to `marfa_tech_api_platform.minimal_api_version`.
- Renamed logger channel `marfatech_api_platform` to `marfa_tech_api_platform`.

## [3.0.1] - 2021-10-28
### Fixed
- Fixed case mismatch between loaded and declared class names: `MarfatechApiPlatformExtension` vs `MarfaTechApiPlatformExtension`.

## [3.0.0] - 2021-10-19
## Changed
- Updated `php` with pattern version `~7.4||~8.0`.
- Updated `marfatech/dto-resolver` with pattern version `^2.0`.
- Updated composer name from `wakeapp/api-platform-bundle` to `marfatech/api-platform-bundle`.
- [BC BREAK] Refactoring namespace to `MarfaTech`.
- [BC BREAK] Renamed root config `wakeapp_api_platform` to `marfatech_api_platform`.
- [BC BREAK] Renamed service `wakeapp_api_platform.factory.api_dto` to `marfatech_api_platform.factory.api_dto`.
- [BC BREAK] Renamed parameter `wakeapp_api_platform.error_code_guesser_service` to `marfatech_api_platform.error_code_guesser_service`.
- [BC BREAK] Renamed parameter `wakeapp_api_platform.response_debug` to `marfatech_api_platform.response_debug`.
- [BC BREAK] Renamed parameter `wakeapp_api_platform.api_result_dto_class` to `marfatech_api_platform.api_result_dto_class`.
- [BC BREAK] Renamed parameter `wakeapp_api_platform.api_area_guesser_service` to `marfatech_api_platform.api_area_guesser_service`.
- [BC BREAK] Renamed parameter `wakeapp_api_platform.error_code_guesser_service` to `marfatech_api_platform.error_code_guesser_service`.
- [BC BREAK] Renamed parameter `wakeapp_api_platform.minimal_api_version` to `marfatech_api_platform.minimal_api_version`.
- [BC BREAK] Renamed logger channel `wakeapp_api_platform` to `marfatech_api_platform`.

## [2.0.13] - 2021-02-24
### Added
- Support PHP ~8.0.
### Changed
- Updated `wakeapp/swagger-resolver-bundle` pattern to the `^0.4.10`.

## [2.0.12] - 2020-12-10
### Changed
- Headers from `ApiResponse` follow direct to client.

## [2.0.11] - 2020-09-16
### Changed
- For `symfony/translation-contracts` added support of the `^2.2`.

## [2.0.10] - 2020-09-10
### Changed
- Accept request parameters in `ApiDtoFactory::getRequestDataByMethod()`

## [2.0.9] - 2020-09-04
### Patch
- Updated `wakeapp/swagger-resolver-bundle` to the `^0.4.8`.

## [2.0.8] - 2020-09-04
### Changed
- Added Symfony 5 support.
- Updated `wakeapp/swagger-resolver-bundle` to the `^0.4.7`.
- Updated `wakeapp/dto-resolver` to the `^1.1`

## [2.0.7] - 2020-01-16
### Added
- `ApiErrorCodeGuesserInterface::class` now is alias for `wakeapp_api_platform.error_code_guesser_service`.

## [2.0.6] - 2019-12-30
### Changed
- Updated `wakeapp/swagger-resolver-bundle` to the `^0.4.6` pattern version.

## [2.0.5] - 2019-12-27
### Fixed
- Fixed deprecations for Symfony

## [2.0.4] - 2019-12-11
### Changed
- Updated `wakeapp/swagger-resolver-bundle` to the `^0.4.5` pattern version.

## [2.0.3] - 2019-09-23
### Added
- Installed `wakeapp/swagger-resolver-bundle` to the `^0.4.3` pattern version.
### Fixed
- Fixed route paths with multiple methods.
### Removed
- Removed `adrenalinkin/swagger-resolver-bundle`.

## [2.0.2] - 2019-09-11
### Changed
- Updated `adrenalinkin/swagger-resolver-bundle` to the `^0.4.2` pattern version.

## [2.0.1] - 2019-07-25
## Added
- Added `symfony/translation-contracts`.
## Fixed
- There was a dependency on `symfony/translations-contracts`, but this bundle was not in the required section.
### Changed
- Var name in `ApiResponseListenerCompiler::process` from `requestDebug` to `responseDebug`.

## [2.0.0] - 2019-04-29
### Added
- Added api versioning mechanism.
- Added `wakeapp_api_platform.minimal_api_version` configuration parameter.
- Added `ApiAreaGuesserInterface::getApiVersion`.
- Added resolving entry DTO's by full request.
- Added `ApiDtoFactory::createApiDtoByRequest`.
- Added popular HTTP codes: `409` `410` `412` `503`.
### Changed
- Added argument resolver instead controller listener.
- Updated `wakeapp/dto-resolver` to the `^1.0` pattern version.
### Removed
- Removed `ApiControllerArgumentListener`.
- Removed `ApiException::HTTP_INTERNAL_SERVER_ERROR`.
- Removed all non-HTTP error codes.
### Fixed
- Return `ApiResponse` instead of `JsonResponse` in the `ApiResponseListener`.

## [1.0.5] - 2019-04-11
### Changed
- Downgraded `DtoResolverInterface` to `JsonSerializable` in the `ApiResponse`.
- Updated `wakeapp/dto-resolver` to the `v0.4.0` version.

## [1.0.4] - 2019-04-09
### Changed
- Renamed monolog.logger channel from `api_platform` to `wakeapp_api_platform`.

## [1.0.3] - 2019-04-05
### Added
- Added `stackTrace` property in `ApiDebugExceptionResultDto`.
- Added `ApiPlatformLogger`.

## [1.0.1] - 2019-04-05
### Changed
- Updated `wakeapp/dto-resolver` to the `v0.3.1` version.
- Use `DtoResolverTrait` instead of `AbstractDtoResolver` in `ApiResultDto`, `ApiDebugExceptionResultDto`.

## [1.0.0] - 2019-03-25
### Changed
- Right response code when get HTTP error.

## [0.1.2] - 2019-03-25
### Changed
- Updated `adrenalinkin/swagger-resolver-bundle` to the `0.4.0` version.

## [0.1.1] - 2019-01-09
### Fixed
- Fixed unclear translation for an error code `22`. 

## [0.1.0] - 2018-08-30
### Added
- First version of this bundle.
