<?php

require_once './.config.php';

ini_set('default_charset', 'UTF-8');

$data = array(
    'url'                   => (!empty($_GET['url']) ? $_GET['url'] : ''),
    'sendRequest'           => (!empty($_GET['sendRequest']) ? $_GET['sendRequest'] : 0),
    'serviceID'             => (!empty($_GET['serviceID']) ? $_GET['serviceID'] : $serviceId),
    'orderID'               => (!empty($_GET['orderID']) ? $_GET['orderID'] : (string) time()),
    'remoteID'              => (!empty($_GET['remoteID']) ? $_GET['remoteID'] : '9999FFFF'),
    'amount'                => (!empty($_GET['amount']) ? $_GET['amount'] : '0.05'),
    'currency'              => (!empty($_GET['currency']) ? $_GET['currency'] : 'PLN'),
    'gatewayID'             => (!empty($_GET['gatewayID']) ? $_GET['gatewayID'] : 106),
    'paymentDate'           => (!empty($_GET['paymentDate']) ? $_GET['paymentDate'] : date('Y-m-d\TH:i', time())),
    'paymentStatus'         => (!empty($_GET['paymentStatus']) ? $_GET['paymentStatus'] : 'PENDING'),
    'paymentStatusDetails'  => (!empty($_GET['paymentStatusDetails']) ? $_GET['paymentStatusDetails'] : 'AUTHORIZED'),
    'hashingAlgorithm'      => (!empty($_GET['hashingAlgorithm']) ? $_GET['hashingAlgorithm'] : 'sha256'),
    'hashingSalt'           => (!empty($_GET['hashingSalt']) ? $_GET['hashingSalt'] : $hashingSalt),
    'hashingSeparator'      => (!empty($_GET['hashingSeparator']) ? $_GET['hashingSeparator'] : $hashingSeparator),
);

function page_header()
{
    printf('<!DOCTYPE html>');
    printf('<html lang="pl">');
    printf('<head>');
    printf('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">');
    printf('<title>ITN sending and debugging</title>');
    printf('</head>');
    printf('<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw=" crossorigin="anonymous">');
    printf('<body>');
    printf('<div class="container">');

    echo configForm();
}

function page_footer()
{
    printf('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>');
    printf('<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo=" crossorigin="anonymous"></script>');
    printf('<script>
$(\'.form-reset\').click(function(event) {
    event.preventDefault();

    var $form = $(this).parents(\'form\').first();
    $(\'input[type="text"]\', $form).val(\'\');
    $(\'select\', $form).each(function(key, select) {
        $(select).prop(\'selectedIndex\', 0);
    });
});
$(\'.form-reset-url\').click(function(event) {
    event.preventDefault();

    var url = document.location.origin;
        url += document.location.pathname;

    document.location = url;
});
</script>');
    printf('</div>');
    printf('</body>');
    printf('</html>');
}

function make_input_number($fieldName, $fieldValue)
{
    return sprintf('<div class="form-group"><label for="%1$s" class="control-label">%1$s</label><input name="%1$s" id="%1$s" type="number" class="form-control" value="%2$d"></div>', $fieldName, $fieldValue);
}

function make_input_text($fieldName, $fieldValue)
{
    return sprintf('<div class="form-group"><label for="%1$s" class="control-label">%1$s</label><input name="%1$s" id="%1$s" type="text" class="form-control" value="%2$s"></div>', $fieldName, $fieldValue);
}

function make_select($fieldName, array $fieldSelects = array(), $fieldValue, array $fieldOptions = array())
{
    $result = sprintf('<div class="form-group"><label for="%1$s" class="control-label">%1$s</label><select name="%1$s" id="%1$s" class="form-control">', $fieldName);
    if (is_array($fieldSelects) && !empty($fieldSelects)) {
        foreach ($fieldSelects as $fieldSelectName) {
            $isSelected = ($fieldValue === $fieldSelectName);
            $result .= sprintf('<option value="%1$s" title="%1$s" %2$s>%1$s</option>', $fieldSelectName, ($isSelected ? 'selected' : ''));
        }
    }
    $result .= sprintf('</select></div>');

    return $result;
}

function page_form(array $data = array())
{
    printf('<form method="GET" action="" class="form-horizontal">');

    printf('<div class="form-group"><label for="%1$s" class="control-label">%1$s</label><input name="%1$s" id="%1$s" type="url" class="form-control" value="%2$s"></div>', 'url', $data['url']);

    echo make_input_number('serviceID', $data['serviceID']);

    echo make_input_number('orderID', $data['orderID']);

    echo make_input_number('remoteID', $data['remoteID']);

    printf('<div class="form-group"><label for="%1$s" class="control-label">%1$s</label><input name="%1$s" id="%1$s" type="number" class="form-control" min="0.05" max="100000.00" step="0.05" value="%2$01.2f"></div>', 'amount', $data['amount']);

    echo make_select('currency', array('PLN', 'EUR'), $data['currency']);

    echo make_input_number('gatewayID', $data['gatewayID']);

    printf('<div class="form-group"><label for="%1$s" class="control-label">%1$s</label><input name="%1$s" id="%1$s" type="datetime-local" class="form-control" value="%2$s"></div>', 'paymentDate', $data['paymentDate']);

    echo make_select('paymentStatus', array('PENDING', 'SUCCESS', 'FAILURE'), $data['paymentStatus']);

    echo make_select('paymentStatusDetails', array('AUTHORIZED', 'ACCEPTED', 'INCORRECT_AMOUNT', 'EXPIRED', 'CANCELLED', 'ANOTHER_ERROR'), $data['paymentStatusDetails']);

    echo make_select('hashingAlgorithm', array('md5', 'sha1', 'sha256', 'sha512'), $data['hashingAlgorithm']);

    echo make_input_text('hashingSalt', $data['hashingSalt']);

    echo make_input_text('hashingSeparator', $data['hashingSeparator']);

    printf('<div class="checkbox"><label for="%1$s" class="control-label"><input type="checkbox" name="%1$s" id="%1$s" value="1">%1$s %2$d</label></div>', 'sendRequest', $data['sendRequest']);

    printf('<div class="form-group">');
    printf('<label for="%1$s" class="control-label"></label><button name="%1$s" id="%1$s" type="submit" class="btn btn-primary">%2$s</button>', 'submit_1', 'Submit');

    printf('<label for="%1$s" class="control-label"></label><button name="%1$s" id="%1$s" type="reset" class="btn btn-default form-reset">%2$s</button>', 'reset_1', 'Reset form');

    printf('<label for="%1$s" class="control-label"></label><button name="%1$s" id="%1$s" type="reset" class="btn btn-default form-reset-url">%2$s</button>', 'reset_2', 'Reset page');

    printf('</div>');

    printf('</form>');
}

function page_itn_make(array $data = array())
{
    $dataIn = $data;

    $hashingAlgorithm = $dataIn['hashingAlgorithm'];
    $hashingSalt      = $dataIn['hashingSalt'];
    $hashingSeparator = $dataIn['hashingSeparator'];

    unset($dataIn['url']);
    unset($dataIn['sendRequest']);
    unset($dataIn['hashingAlgorithm']);
    unset($dataIn['hashingSalt']);
    unset($dataIn['hashingSeparator']);

    $dataIn['paymentDate'] = DateTime::createFromFormat('Y-m-d\TH:i', $dataIn['paymentDate'])->format('YmdHis');

    $dataIn['hash'] = '';
    foreach ($dataIn as $name => $value) {
        if (mb_strtolower($name) === 'hash' || empty($value)) {
            continue;
        }
        $dataIn['hash'] .= $value . $hashingSeparator;
    }
    $dataIn['hash'] .= $hashingSalt;
    $dataIn['hash'] = hash($hashingAlgorithm, $dataIn['hash']);

    $xml = new XMLWriter();
    $xml->openMemory();
    $xml->startDocument('1.0', 'UTF-8', 'yes');
    $xml->startElement('transactionList');
    $xml->writeElement('serviceID', $dataIn['serviceID']);
    $xml->startElement('transactions');
    $xml->startElement('transaction');
    $xml->writeElement('orderID', $dataIn['orderID']);
    $xml->writeElement('remoteID', $dataIn['remoteID']);
    $xml->writeElement('amount', $dataIn['amount']);
    $xml->writeElement('currency', $dataIn['currency']);
    $xml->writeElement('gatewayID', $dataIn['gatewayID']);
    $xml->writeElement('paymentDate', $dataIn['paymentDate']);
    $xml->writeElement('paymentStatus', $dataIn['paymentStatus']);
    $xml->writeElement('paymentStatusDetails', $dataIn['paymentStatusDetails']);
    $xml->endElement(); // transaction
    $xml->endElement(); // transactions
    $xml->writeElement('hash', $dataIn['hash']);
    $xml->endElement(); // transactionList

    return $xml->outputMemory();
}

function page_itn_check($string)
{
    $hasFeff = preg_match('/^[\pZ\p{Cc}\x{feff}]+|[\pZ\p{Cc}\x{feff}]+$/ux', $string, $matches);

    return sprintf('<span class="%s">%s</span>', (($hasFeff) ? 'bg-danger' : 'bg-success'), $string);
}

function page_itn_display($itnXml, $showAdd = false)
{
    if (!empty($itnXml)) {
        if ($showAdd) {
            $itnXmlEsc = htmlentities($itnXml, ENT_SUBSTITUTE);

            printf('<pre><strong>XML RAW:</strong> %s</pre>', PHP_EOL . page_itn_check($itnXmlEsc));
            printf('<pre><strong>XML to JSON:</strong> %s</pre>', PHP_EOL . json_encode($itnXmlEsc));
        }

        $dom = new DOMDocument();
        $dom->loadXML($itnXml, (LIBXML_NONET));
        $dom->formatOutput = true;
        $itnXmlFormated = $dom->saveXml();

        printf('<pre><strong>XML FORMATED:</strong> %s</pre>', PHP_EOL . htmlspecialchars($itnXmlFormated, ENT_SUBSTITUTE));

        if ($showAdd) {
            $itnXmlData = array();
            $xmlReader = new XMLReader();
            $xmlReader->XML($itnXml, 'UTF-8', (LIBXML_NONET));
            while ($xmlReader->read()) {
                switch ($xmlReader->nodeType) {
                    case XMLREADER::ELEMENT:
                        $nodeName = $xmlReader->name;
                        $xmlReader->read();
                        $nodeValue = $xmlReader->value;
                        if (!empty($nodeName) && !empty(trim($nodeValue))) {
                            $itnXmlData[$nodeName] = $nodeValue;
                        }
                        break;
                }
            }
            $xmlReader->close();
            printf('<pre><strong>DATA PARSED:</strong> %s</pre>', PHP_EOL . var_export($itnXmlData, 1));
        }
    }
}

function page_itn_send($itnXml, $data)
{
    if (empty($data['url']) || empty($data['sendRequest'])) {
        return '';
    }

    $requestUrl = $data['url'];
    $requestData = array(
        'transactions' => base64_encode($itnXml),
    );
    $requestOptions = array(
        'form_params'       => $requestData,
        'allow_redirects'   => false,
        'http_errors'       => false,
        'headers'           => array(
            'Cookie'        => 'XDEBUG_SESSION=PHPSTORM',
        ),
    );

    $client = new GuzzleHttp\Client();
    $result = $client->post($requestUrl, $requestOptions)->getBody();

    return $result;
}

function page_itn_show_helper($itnXml, $data)
{
    if (empty($data['url']) || empty($data['sendRequest'])) {
        return '';
    }

    $requestUrl = $data['url'];
    $requestData = array(
        'transactions' => base64_encode($itnXml),
    );

    $requestDataString = implode(', ', array_map(
        function ($v, $k) {
            return $k . '=' . $v;
        },
        $requestData,
        array_keys($requestData)
    ));

    printf('<pre><strong>curl request:</strong>%s curl -I --request POST --data "%s" %s</pre>', PHP_EOL, $requestDataString, $requestUrl);

    printf('<form method="POST" action="%s" target="_blank">', $data['url']);
    printf('<input type="hidden" name="transactions" value="%s">', $requestData['transactions']);
    printf('<label for="%1$s" class="control-label"></label><button name="%1$s" id="%1$s" type="submit" class="btn btn-primary">%2$s</button>', 'submit_1', 'Send from browser');
    printf('</form>');
}

page_header();
printf('<div class="row">');
printf('<div class="col-md-6">');
page_form($data);
printf('</div>');

printf('<div class="col-md-6">');
$itn = page_itn_make($data);
page_itn_display($itn, false);

if (!empty($data['url']) && !empty($data['sendRequest'])) {
    $itnResponse = page_itn_send($itn, $data);
    printf('<hr>');
    page_itn_show_helper($itn, $data);
    printf('<hr>');
    page_itn_display($itnResponse, true);
}
printf('</div>');

printf('</div>');
page_footer();
