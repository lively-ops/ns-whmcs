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
