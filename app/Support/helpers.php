<?php
    function queryMKMAPI($url) {
        $method             = "GET";
        $url                = env("MKM_URL").$url;
        $appToken           = env("MKM_TOKEN");
        $appSecret          = env("MKM_TOKEN_SECRET");
        $accessToken        = env("MKM_ACCESS_TOKEN");
        $accessSecret       = env("MKM_ACCESS_TOKEN_SECRET");
        $nonce              = uniqid();
        $timestamp          = time();
        $signatureMethod    = "HMAC-SHA1";
        $version            = "1.0";
        $params             = array(
        'realm'                     => $url,
        'oauth_consumer_key'        => $appToken,
        'oauth_token'               => $accessToken,
        'oauth_nonce'               => $nonce,
        'oauth_timestamp'           => $timestamp,
        'oauth_signature_method'    => $signatureMethod,
        'oauth_version'             => $version,
        );
        $baseString         = strtoupper($method) . "&";
        $baseString        .= rawurlencode($url) . "&";
        $encodedParams      = array();
        foreach ($params as $key => $value)
        {
        if ("realm" != $key)
        {
        $encodedParams[rawurlencode($key)] = rawurlencode($value);
        }
        }
        ksort($encodedParams);
        $values             = array();
        foreach ($encodedParams as $key => $value)
        {
        $values[] = $key . "=" . $value;
        }
        $paramsString       = rawurlencode(implode("&", $values));
        $baseString        .= $paramsString;
        $signatureKey       = rawurlencode($appSecret) . "&" . rawurlencode($accessSecret);
        $rawSignature       = hash_hmac("sha1", $baseString, $signatureKey, true);
        $oAuthSignature     = base64_encode($rawSignature);

        $params['oauth_signature'] = $oAuthSignature;

        $header             = "Authorization: OAuth ";
        $headerParams       = array();
        foreach ($params as $key => $value)
        {
        $headerParams[] = $key . "=\"" . $value . "\"";
        }
        $header            .= implode(", ", $headerParams);

        $curlHandle         = curl_init();

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);

        $content            = curl_exec($curlHandle);
        $info               = curl_getinfo($curlHandle);
        curl_close($curlHandle);
        $decoded            = simplexml_load_string($content);
        return $decoded;
    }