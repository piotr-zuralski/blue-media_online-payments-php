# Rejestr zmian

## 2.3.2 (2016-12-06)
- **Dodano** obsługę pełnych danych w komunikatach ITN
- **Dodano** obsługę testów w [CodeCeption](http://codeception.com/)
- **Dodano** bibliotekę [symfony/polyfill](https://github.com/symfony/polyfill)
- **Dodano** `Transformer` (`BlueMedia\OnlinePayments\Action\ITN\Transformer`) dla komunikatów ITN
- **Dodano** obsługę nowych statusów dla komunikatu ITN (`BlueMedia\OnlinePayments\Model\ItnIn`):
    - paymentStatusDetails:
        - `ItnIn::PAYMENT_STATUS_DETAILS_CONFIRMED`
        - `ItnIn::PAYMENT_STATUS_DETAILS_REJECTED`
        - `ItnIn::PAYMENT_STATUS_DETAILS_REJECTED_BY_USER`
    - verificationStatus:
        - `ItnIn::VERIFICATION_STATUS_*`
- **Zmiana** w przykładach zasymulowanych żądań (examples/itnIn_02.php, examples/itnIn_03.php, examples/itnIn_04.php)
- **Zmiana** strukturę katalogu `tests` w związku z obsługą testów w [CodeCeption](http://codeception.com/)
- **Zmiana** `BlueMedia\OnlinePayments\Model\ItnIn::toArray` została oznaczona jako `@deprecated`, należy używać `BlueMedia\OnlinePayments\Action\ITN\Transformer::objectToArray`
- **Zmiana** w `BlueMedia\OnlinePayments\Model\TransactionStandard::getHtmlForm` dodano JavaScript z automatycznym wysyłaniem formularza  
- **Usunięcie** bezpośredniego wsparcia dla PHPUnit
- **Usunięcie** w `BlueMedia\OnlinePayments\Model\TransactionStandard::getHtmlForm` usunięto `style="display: none;"` z elementu `<form>`

## 2.3.1 (2015-07-29)

## 2.2.1 (2015-06-21)

## 2.2.0 (2015-03-18)

## 2.1.4 (2015-02-06)

## 2.0.6 (2014-12-22)
