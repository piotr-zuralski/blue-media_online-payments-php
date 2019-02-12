# Changelog

## 2.5.0 (2019-02-04)


## 2.4.0 (2018-02-15)
- **Added** Pay way list support
- **Changed** PHPDoc for methods changed from Polish into English

## 2.3.2 (2016-12-06)
- **Added** Full data support for messages in ITN (Instant Transaction Notification)
- **Added** tests support in [CodeCeption](http://codeception.com/)
- **Added** library [symfony/polyfill](https://github.com/symfony/polyfill)
- **Added** `Transformer` (`BlueMedia\OnlinePayments\Action\ITN\Transformer`) for messages in ITN
- **Added** support for new statuses in ITN (`BlueMedia\OnlinePayments\Model\ItnIn`):
    - paymentStatusDetails:
        - `ItnIn::PAYMENT_STATUS_DETAILS_CONFIRMED`
        - `ItnIn::PAYMENT_STATUS_DETAILS_REJECTED`
        - `ItnIn::PAYMENT_STATUS_DETAILS_REJECTED_BY_USER`
    - verificationStatus:
        - `ItnIn::VERIFICATION_STATUS_*`
- **Changed** in examples of simulated requests (`examples/itnIn_02.php`, `examples/itnIn_03.php`, `examples/itnIn_04.php`)
- **Changed** directory structure `tests` due to handling tests with [CodeCeption](http://codeception.com/)
- **Changed** `BlueMedia\OnlinePayments\Model\ItnIn::toArray` was marked as deprecated (`@deprecated`), you should use `BlueMedia\OnlinePayments\Action\ITN\Transformer::objectToArray` instead
- **Changed** in `BlueMedia\OnlinePayments\Model\TransactionStandard::getHtmlForm` added JavaScript with automatic form submission
- **Removed** direct support for PHPUnit
- **Removed** in `BlueMedia\OnlinePayments\Model\TransactionStandard::getHtmlForm` removed `style="display: none;"` from HTML element `<form>`

## 2.3.1 (2015-07-29)

## 2.2.1 (2015-06-21)

## 2.2.0 (2015-03-18)

## 2.1.4 (2015-02-06)

## 2.0.6 (2014-12-22)
