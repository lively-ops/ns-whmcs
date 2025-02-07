<?php

/**
 * Function to extract TLD from the domain name
 *
 * @param string $domain The full domain name (e.g., example.com)
 * @return string|null The extracted TLD or null if the TLD cannot be extracted
 */
function extractTLDFromDomain($domain) {
    // Split the domain by the dot (.)
    $domainParts = explode('.', $domain);

    // Check if there are at least two parts (e.g., "example.com")
    if (count($domainParts) >= 2) {
        // Extract the last part as the TLD
        $tld = end($domainParts);
        return $tld;
    }

    // Return null if TLD cannot be extracted
    return null;
}


/**
 * Function to map API domain status to standard WHMCS domain status response
 *
 * @param string $apiStatus The domain status retrieved from the API
 * @return string Standard WHMCS domain status response (e.g., 'Active', 'Expired', 'Grace', etc.)
 */
function mapApiStatusToWhmcsStatus($apiStatus) {
    switch ($apiStatus) {
        case 'Pending Outbound Transfer':
            return 'Pending Transfer';
        case 'Active':
            return 'Active';
        case 'Deleted':
            return 'Expired';
        case 'Expired (grace period)':
            return 'Grace';
        case 'Expired (pending delete)':
            return 'Pending Delete';
        case 'Expired (restore period)':
            return 'Redemption';
        default:
            return 'Inactive';
    }
}


