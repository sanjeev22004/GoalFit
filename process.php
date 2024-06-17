
<?php
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $age = intval($_POST['age']);
        $weight = floatval($_POST['weight']);
        $height = intval($_POST['height']);
        $goal = $_POST['goal'];

      
        $api_url = 'https://exercisedb.p.rapidapi.com/exercises';
        
       
        $api_key = '8be4498af6msh96db5b74f19cff4p1ba17djsn8f915c436f01';
        $api_host = 'exercisedb.p.rapidapi.com';

        $curl = curl_init();

        
        curl_setopt_array($curl, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'x-rapidapi-key: ' . $api_key,
                'x-rapidapi-host: ' . $api_host,
            ],
        ]);

      
        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            throw new Exception("cURL Error #: " . $err);
        } else {
            
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($http_code === 200) {
               
                $exercises = json_decode($response, true);

                
                $filtered_exercises = array_filter($exercises, function($exercise) use ($goal) {
                    if ($goal == 'weight_loss') {
                        return $exercise['bodyPart'] === 'cardio'; 
                    } elseif ($goal == 'muscle_gain') {
                        return $exercise['bodyPart'] === 'strength'; 
                    } else {
                        return true; 
                    }
                });

                
                echo '<h2>Your Personalized Fitness Plan</h2>';
                foreach ($filtered_exercises as $exercise) {
                    echo '<p><strong>' . htmlspecialchars($exercise['name']) . '</strong>: ' . htmlspecialchars($exercise['target']) . '</p>';
                }
            } else {
                throw new Exception("Failed to retrieve data. Response code: " . $http_code);
            }
        }

        // Close curl session
        curl_close($curl);

    } else {
        throw new Exception('Invalid request method.');
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
