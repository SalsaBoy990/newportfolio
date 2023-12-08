<?php

class Validate extends Trongate
{
    /**
     * Luhn algorithm to determine the validity of the credit card number
     * @see http://en.wikipedia.org/wiki/Luhn_algorithm
     */
    public function _validate_card_number($card_number, $field_name = 'card_number'): void
    {
        $sum = '';

        foreach (str_split(strrev((string) $card_number)) as $i => $d) {
            // if it is odd, multiply by 2
            if ($i % 2 !== 0) {
                $num = $d * 2;

                // if $num is > 10, calculate the sum of the digits
                if ($num > 10) {
                    $sum .= floor($num / 10) + ($num % 10);
                } else {
                    $sum .= $num;
                }
            } else { // use the original number
                $sum .= $d;
            }
        }
        // The sum must end with zero
        if (!(array_sum(str_split($sum)) % 10 === 0)) {
            $_SESSION['form_submission_errors'][$field_name][] = 'The Card number is invalid.';
        }
    }


    /**
     * Check if month in MM format is valid
     */
    public function _validate_expiration_month($field_name = 'month', $label = 'Expiration month'): void
    {
        // validate month in MM format
        $valid_months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        if (!in_array(post($field_name, true), $valid_months)) {
            // errors are stored in this session item
            $_SESSION['form_submission_errors'][$field_name][] = 'The '.$label.' field is in incorrect format (must be to digits like \'01\')';
        }
    }


    /**
     * check if credit / debit card is valid
     */
    public function _validate_card_expiration(
        $card_field_name = 'card_number',
        $month_field_name = 'month',
        $year_field_name = 'year'
    ): void {

        $month = post($month_field_name, true);
        $year = post($year_field_name, true);
        $year = intval('20'.$year);

        $current_year = intval(date('Y'));
        $current_month = intval(date('m'));


        if ($year < $current_year) {
            $_SESSION['form_submission_errors'][$card_field_name][] = 'Card is expired! Expired year.';
        } else {
            if ($year === $current_year) {

                if ($month < $current_month) {
                    $_SESSION['form_submission_errors'][$card_field_name][] = 'Card is expired! Expired month.';

                } else {
                    if ($month === $current_month) {
                        // April, June, September, November have the duration of 30 days
                        if ($month === 4 || $month === 6 || $month === 9 || $month === 11) {
                            $day = 30;
                        } else {
                            if ($month === 2) {
                                // Leap year
                                if ((($year % 4 === 0) && ($year % 100 !== 0)) || $year % 400 === 0) {
                                    $day = 29;
                                } else {
                                    $day = 28;
                                }
                            } else {
                                $day = 31;
                            }
                        }
                        $current_date_time = date('Y-m-d H:i:s');
                        if ($month < 10) {
                            $month = '0'.$month;
                        }
                        $card_valid_date = $year.'-'.$month.'-'.$day.' 23:59:59';
                        $seconds = strtotime($card_valid_date) - strtotime($current_date_time);
                        if ($seconds < 0) {
                            $_SESSION['form_submission_errors'][$card_field_name][] = 'Your card expired last month.';
                        }
                    }
                }
            }
        }

    }


    /**
     * Outputs validation errors, but with an option to keep, or unset the $_SESSION property
     * that is storing the error messages
     */
    function _validation_errors($opening_html = null, $closing_html = null, $keep = false): string
    {

        if (isset($_SESSION['form_submission_errors'])) {

            $validation_err_str = '';
            $validation_errors = [];
            $closing_html = (isset($closing_html)) ? $closing_html : false;
            $form_submission_errors = $_SESSION['form_submission_errors'];

            if ((isset($opening_html)) && (gettype($closing_html) == 'boolean')) {
                //build individual form field validation error(s)
                if (isset($form_submission_errors[$opening_html])) {
                    $validation_err_str .= '<div class="validation-error-report">';
                    $form_field_errors = $form_submission_errors[$opening_html];
                    foreach ($form_field_errors as $validation_error) {
                        $validation_err_str .= '<div>&#9679; '.$validation_error.'</div>';
                    }
                    $validation_err_str .= '</div>';
                }

                return $validation_err_str;

            } else {
                //normal error reporting
                foreach ($form_submission_errors as $key => $form_field_errors) {
                    foreach ($form_field_errors as $form_field_error) {
                        $validation_errors[] = $form_field_error;
                    }
                }

                if (!isset($opening_html)) {
                    $opening_html = '<div class="panel danger">';
                    $closing_html = '</div>';
                }

                foreach ($validation_errors as $form_submission_error) {
                    $validation_err_str .= $opening_html.$form_submission_error.$closing_html;
                }

                if ($keep === false) {
                    $this->_clear_validation_errors();
                }

            }
            echo $validation_err_str;
        }

        return '';

    }


    /**
     * Unset the $_SESSION property that is storing the error messages
     */
    function _clear_validation_errors(): void
    {
        unset($_SESSION['form_submission_errors']);
    }


    /**
     * Check if a form field has error messages
     */
    function _has_error(string $field_name): bool
    {
        return isset($_SESSION['form_submission_errors'][$field_name]);
    }


    /**
     * Get the error messages that belongs to a form field
     */
    function _get_error(string $field_name): ?string
    {
        return $_SESSION['form_submission_errors'][$field_name][0] ?? null;
    }


    /**
     * Set the error message from the exception (mainly)
     */
    function set_error(string $message, string $name = 'exception') {
        $_SESSION['form_submission_errors'][$name][] = $message;
    }


    /**
     * Get data from posted form fields. $input_array is storing the fields names.
     */
    function _get_data_from_post(array $input_array, bool $clean_up = true): array
    {
        $data = [];

        foreach ($input_array as $key => $value) {
            $data[htmlspecialchars($value)] = post($value, $clean_up ? true : null);
        }

        return $data;
    }

    // some basic sanitizing: remove trailing whitespace, html tags
    function sanitize_text(string $str): string
    {
        $str = trim($str);
        return strip_tags($str);
    }

    /**
     * Check $_FILES[][name]
     *
     * @param string $filename - Uploaded file name.
     */
    function is_filename_valid(string $filename): bool
    {
        return (bool) preg_match("`^[-0-9A-Z_\.]+$`i", $filename);
    }

    /**
     * @param string $filename - Uploaded file name.
     */
    function is_filename_too_long(string $filename): bool
    {
        return mb_strlen($filename, "UTF-8") > 225;
    }
}
