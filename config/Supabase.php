<?php
class Supabase {
    private $url = "https://dszzjdzferfxnbfthdmi.supabase.co";
    private $key = "sb_publishable_IIEgstD45eHairC_VTADMg_DWV9f60M";

    public function request($endpoint, $method = 'GET', $data = null) {
        $ch = curl_init();
        $url = $this->url . "/rest/v1/" . $endpoint;

        $headers = [
            "apikey: " . $this->key,
            "Authorization: Bearer " . $this->key,
            "Content-Type: application/json",
            "Prefer: return=representation"
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        }

        return false;
    }

    public function get($table, $query = "") {
        $endpoint = $table . ($query ? "?" . $query : "");
        return $this->request($endpoint, 'GET');
    }

    public function post($table, $data) {
        return $this->request($table, 'POST', $data);
    }

    public function patch($table, $id, $data) {
        return $this->request($table . "?id=eq." . $id, 'PATCH', $data);
    }

    public function delete($table, $id) {
        return $this->request($table . "?id=eq." . $id, 'DELETE');
    }
}
?>
