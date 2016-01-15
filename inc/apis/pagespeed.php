<?php

    class PageSpeedAPI {
        public function __construct() {

            $this->curl = curl_init();
        }

        public function get_results($url) {
            if ($url != '') {
                curl_setopt($this->curl, CURLOPT_URL, "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=" . $url . "&key={{API_KEY}}");
                curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);

                $return = curl_exec ($this->curl);
                curl_close ($this->curl);

                return json_decode($return);
            }
            return 'Error';
        }

        public function format_summary($string, $args = null) {
            if ($args) {
                foreach ($args as $arg) {
                    if (strtolower($arg->key) == 'link') {
                        $string = str_replace('{{BEGIN_LINK}}', '<a href="' . $arg->value . '">', $string);
                        $string = str_replace('{{END_LINK}}', '</a>', $string);
                    }
                    if (strtolower($arg->key) == 'num_css') {
                        $string = str_replace('{{NUM_CSS}}', $arg->value, $string);
                    }
                    if (strtolower($arg->key) == 'num_scripts') {
                        $string = str_replace('{{NUM_SCRIPTS}}', $arg->value, $string);
                    }
                }
            }

            $string = str_replace('Learn more', '<br/>Learn More', $string);

            return $string;
        }
    }
