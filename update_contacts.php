<?php
	$location = $_GET['location'];
	$contact_id = $_GET['contact_id'];
	$disposition = $_GET['disposition'];
	$callback = $_GET['callback'];
	$agent = $_GET['agent'];
	
// Define an array to map disposition codes to descriptions	
	$dispo_descriptions = [
    		'LOST1' => 'Too expensive',
		'LOST2' => 'Let me think about it',
		'LOST3' => 'I dont have my card',
    		'LOST4' => 'I dont get paid until',
    		'LOST5' => 'I need to talk to',
    		'LOST6' => 'I dont have my work roaster',
		'LOST7' => 'Im driving',
		'LOST8' => 'Sent payment link',
		'LOST9' => 'The patient hung up',
    		'LOST10' => 'Calling patient back Should h',
    		'LOST11' => 'Others',
		'NI' => 'Disqualified',
		'DNC' => 'Disqualified',
    		'DSQ' => 'Disqualified',
		'CALLBK' => 'Call Back',
		'CBHOLD' => 'Call Back'
        // Add more dispositions as needed
    ];

// Get the description based on the disposition code
    $dispo_description = isset($dispo_descriptions[$disposition]) ? $dispo_descriptions[$disposition] : 'Unknown disposition';

	
//	$agent_name = $_GET['patient_consultant'];
//	$lead_id = $_GET['vicidial_lead_id'];
//	$list_id = $_GET['vicidial_list_id'];
//	$list_name = $_GET['vicidial_list_name'];
	
 
// Refresh token obtained during authentication (Refresh token not real, it's demo data)
$refreshToken = "mF1dGhDbGFzc0lkIjoib3lacnp5T2tVMXNtRUxYRWhXSVMiLCJzb3VyY2UiOiJJTlRFR1JBVElPTkwYTE3ZjI2N2ExMGM5MTAyLWx3ZjIzeHExIiwiY2hhbm5lbCI6Ik9BVVRIIiwicHJpbWFyeUF1dGhDbGFzc0lkIjoib3lacnp5T2tVMXNtRUxYRWhXSVMiLCJvYXV0aE1ldGEiOnsic2NvcGVzIjpbImNhbGVuZGFycy53cml0ZSIsImNhbGVuZGFycy5yZWFkb25seSIsImNhbGVuZGFycy9ldmVudHMucmVhZG9ubHkiLCJjYWxlbmRhcnMvZXZlbnRzLndyaXRlIiwiY29udGFjdHMud3JpdGUiLCJjb250YWN0cy5yZWFkb25seSIsImxvY2F0aW9ucy9jdXN0b21GaWVsZHMucmVhZG9ubHkiLCJsb2NhdGlvbnMvY3VzdG9tRmllbGRzLndyaXRlIiwibG9jYXRpb25zL2N1c3RvbVZhbHVlcy5yZWFkb25seSIsImxvY2F0aW9ucy9jdXN0b21WYWx1ZXMud3JpdGUiXSwiY2xpZW50IjoiNjY0YjU2YzkwYTE3ZjI2N2ExMGM5MTAyIiwiY2xpZW50S2V5IjoiNjY0YjU2YzkwYTE3ZjI2N2ExMGM5MTAyLWx3ZjIzeHExIn0sImlhdCI6MTcxNjk3NzkwOS4wNjQsImV4cCI6MTc0ODUxMzkwOS4wNjQsInVuaXF1ZUlkIjoiODI5ZWU3ODMtYTQ2Ni00MDgxLWEwOTgtOGIwM2RkMjc2YWZmIn0.Ypmd6kB5nw_cDuffeWNEMr30MgoWRix6Dz4FyE9nzM4bIT4yOQWbiwy_kbg7rW8aw3iwygsOQzT6veDYAeWEVrAZHSjVKd24VEmeXgiGbWSEE5cbSy1a1EVLLQshRIKflP1D2-UGk3pp4MvBKPdUzTmfEfuHbvROn1y7rxnMeRBNu4FS6NorMc5PyopSEhYhrroK0NS63qnF8q6txJH-KV3sCsmHCRDGt8SaO1PGGtcDqSv8-7k8bVujZ3FBLfyZpxmpfN6c5Gkfh1IogUEzAVYzXhUkyKUpGGDmd4PK4jVDVjVbc-0w0mTyYMnuGyQXQ069qSakfqy-L9lVJv2267DhxF6_l9aFbPopFJ2SOtZnKPeGAa2pfud1IlXRw5vbiOzGYnZL-i4h_z-AEzd9azouPSUZJ3cb7RdE6yZzIMybj-jku_zrqQY0FWhJ9MRZLAmRmeZpiV3uB1h0jdHj_3z8Zk6IYzlkrtA9Lvopa1ykxCl2XddspEqkboJb9m2GWeQ-bYFaoAfIR9NwOtUKBJjq5d9edXNhUwQnp-U6u5DPD6ARpAQ3BF5HOEOCcmYI3fx-ZTXbGAInOw4zLTw-PziGkNE2oT4BIEBhuvxM3UgHaeU8LwIj0irmiyv5cMch6LNflzqXejyySjNuDcafww45YTYOypv5WlXZRImgqgc";

// Your client ID and client secret (ID and Secret not real, it's demo data)
$clientID = "90a17f267a10c9102";
$clientSecret = "ed42-0022-4b49-9e1b-7a85273";

// Token endpoint
$tokenEndpoint = "https://services.leadconnectorhq.com/oauth/token";

// Endpoint to update contact
$updateContactEndpoint = "https://services.leadconnectorhq.com/contacts/$contact_id";


// Prepare the request body to refresh token
$refreshData = array(
    'grant_type' => 'refresh_token',
    'refresh_token' => $refreshToken,
    'client_id' => $clientID,
    'client_secret' => $clientSecret
);

// Initialize cURL session to refresh token
$ch = curl_init($tokenEndpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($refreshData));

// Execute request to refresh token
$refreshResponse = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close cURL session
curl_close($ch);

if ($httpCode == 200) {
    // Successful response, parse the JSON
    $refreshResponseData = json_decode($refreshResponse, true);
    
    // New access token
    $accessToken = $refreshResponseData['access_token'];
//    echo "New Access Token: " . $accessToken;
    // Prepare the request body to update contact
    $updateData = array(
 //       'firstName' => "$firstName",
 //       'lastName' => "$lastName",
 //		'city' => "$disposition",

// Add other Custom fields fields you want to update here
		'customFields' => [
        [
                'id' => '$contact_id',
                'key' => 'phone_consult_appt_date',
                'field_value' => "$callback"
        ],
		[
                'id' => '$contact_id',
                'key' => 'lead_status_test',
                'field_value' => "$disposition"
        ],
				[
                'id' => '$contact_id',
                'key' => 'lost_reason',
                'field_value' => "$dispo_description"
        ],
						[
                'id' => '$contact_id',
                'key' => 'vicidial_user_id',
                'field_value' => "$agent"
        ]
    ],		
		
    );

    // Prepare cURL request to update contact
    $updateHeaders = array(
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
		'Version: 2021-07-28'
    );

    $updateCh = curl_init($updateContactEndpoint);
    curl_setopt($updateCh, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($updateCh, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($updateCh, CURLOPT_HTTPHEADER, $updateHeaders);
    curl_setopt($updateCh, CURLOPT_POSTFIELDS, json_encode($updateData));

    // Execute request to update contact
    $updateResponse = curl_exec($updateCh);
    $updateHttpCode = curl_getinfo($updateCh, CURLINFO_HTTP_CODE);

    // Close cURL session
    curl_close($updateCh);

    if ($updateHttpCode == 200) {
        // Successfully updated contact
        echo "Contact updated successfully.";
    } else {
        // Error updating contact
        echo "Error updating contact: " . $updateResponse;
    }
} else {
    // Error refreshing token
    echo "Error refreshing token: " . $refreshResponse;
}

?>
