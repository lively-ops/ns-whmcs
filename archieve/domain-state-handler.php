<?php

// Include the policies array
require_once 'expiration-policies.php';

/**
 * Function to calculate domain state based on expiry date and renewal status
 *
 * @param string $currentExpiryDate The current expiry date from WHMCS
 * @param string $apiExpiryDate The expiry date fetched from Namesilo API
 * @param string $tld The TLD (top-level domain) of the domain
 * @return string Domain state: 'Expired (grace period)', 'Expired (restore period)', 'Expired (pending delete)', 'Deleted', or 'Active'
 */
function calculateDomainState($currentExpiryDate, $apiExpiryDate, $tld) {
    global $expirationPolicies;
    $currentExpiryTimestamp = strtotime($currentExpiryDate);
    $apiExpiryTimestamp = strtotime($apiExpiryDate);
    $daysDifference = floor(($apiExpiryTimestamp - time()) / (60 * 60 * 24));

    // Check if the TLD belongs to any specific group with a defined expiration policy
    foreach ($expirationPolicies['groups'] as $groupKey => $group) {
        if (in_array($tld, $group['tlds'])) {
            if ($currentExpiryTimestamp === $apiExpiryTimestamp) {
                // Domain has not been renewed, and the expiry date remains the same
                if (is_array($group['grace'])) {
                    if ($daysDifference >= $group['grace']['min'] && $daysDifference <= $group['grace']['max']) {
                        return 'Expired (grace period)';
                    }
                } elseif ($daysDifference === $group['grace']) {
                    return 'Expired (grace period)';
                }

                // Check if the 'restore' period is defined for the group
                if (isset($group['restore'])) {
                    if ($daysDifference >= $group['restore']['min'] && $daysDifference <= $group['restore']['max']) {
                        return 'Expired (restore period)';
                    }
                }

                if ($daysDifference === $group['pending_delete']) {
                    return 'Expired (pending delete period)';
                }

                if (is_array($group['deleted'])) {
                    if ($daysDifference >= $group['deleted']['min'] && (!isset($group['deleted']['max']) || $daysDifference <= $group['deleted']['max'])) {
                        return 'Deleted';
                    }
                } elseif ($daysDifference === $group['deleted']) {
                    return 'Deleted';
                }
            } else {
                // Domain has been renewed, and the expiry date has changed
                return 'Active';
            }
        }
    }

    // If the TLD does not belong to any specific group or no match is found, use the default policy
    if ($currentExpiryTimestamp === $apiExpiryTimestamp) {
        $defaultPolicy = $expirationPolicies['default'];

        if (is_array($defaultPolicy['grace'])) {
            if ($daysDifference >= $defaultPolicy['grace']['min'] && $daysDifference <= $defaultPolicy['grace']['max']) {
                return 'Expired (grace period)';
            }
        } elseif ($daysDifference === $defaultPolicy['grace']) {
            return 'Expired (grace period)';
        }

        // Check if the 'restore' period is defined for the default policy
        if (isset($defaultPolicy['restore'])) {
            if ($daysDifference >= $defaultPolicy['restore']['min'] && $daysDifference <= $defaultPolicy['restore']['max']) {
                return 'Expired (restore period)';
            }
        }

        if ($daysDifference === $defaultPolicy['pending_delete']) {
            return 'Expired (pending delete period)';
        }

        if (is_array($defaultPolicy['deleted'])) {
            if ($daysDifference >= $defaultPolicy['deleted']['min'] && (!isset($defaultPolicy['deleted']['max']) || $daysDifference <= $defaultPolicy['deleted']['max'])) {
                return 'Deleted';
            }
        } elseif ($daysDifference === $defaultPolicy['deleted']) {
            return 'Deleted';
        }
    } else {
        // Domain has been renewed, and the expiry date has changed
        return 'Active';
    }

    // If none of the above conditions match, consider the domain as active
    return 'Active';
}

//// Sample usage for testing
//$currentExpiryDate = '2023-07-31';
//$apiExpiryDate = '2023-08-15';
//$tld = 'example';
//
//$domainState = calculateDomainState($currentExpiryDate, $apiExpiryDate, $tld);
//echo "Domain state: $domainState";
