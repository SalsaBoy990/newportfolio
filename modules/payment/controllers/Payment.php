<?php

final class Payment extends Trongate
{
    /* CLASS CONSTANTS */

    // https://app.freecurrencyapi.com/dashboard
    private const API_KEY = 'WkQyonwTeedm0yV5Rpixj2m3iu9RzcwAanPhziFZ'; // DO NOT COMMIT THE REAL KEY
    private const API_URL = 'https://api.freecurrencyapi.com/v1/latest';

    // Min and max limits for the amount to pay
    private const MIN = 1;
    private const MAX = 1000000;

    // list all form field names
    private const INPUT_FIELDS = [
        'card_number', 'month', 'year', 'amount', 'cvv', 'full_name', 'email_address', 'currency_id'
    ];


    /* CLASS PROPERTIES */

    private string $from_currency;
    private string $to_currency;

    private string $card_number;
    private string $month;
    private string $year;
    private float $amount;
    private string $cvv;
    private string $full_name;
    private string $email_address;

    private float $converted_amount;
	private string $template_to_use = 'clean';


    public function __construct($module_name = null)
    {
        parent::__construct($module_name);

        // payment data
        $this->card_number = '';
        $this->month = '';
        $this->year = '';
        $this->cvv = '';

        $this->amount = 150000; // in HUF
        $this->converted_amount = 0.0; // in EUR or in chosen currency

        $this->from_currency = 'HUF';
        $this->to_currency = 'EUR';

        $this->full_name = '';
        $this->email_address = '';

        // Validate module (child)
        $this->module('form_validator');
        $this->module('api_helper');

    }


    /* FORM METHODS */

    // the html payment form endpoint
    function form()
    {
        $data = $this->_get_data_from_post();

        $data['view_file'] = 'index';
        $data['form_location'] = str_replace('/form', '/submit', current_url());
        $data['currency_options'] = $this->_get_currency_options($data['currency_id']);


        $this->template($this->template_to_use, $data);
    }

    // setup values for the currency select field
    private function _get_currency_options(string $currency_id): array
    {
        if ($currency_id === '') {
            $options[''] = 'Select currency...';
        }
        $options['eur'] = 'EUR';
        $options['usd'] = 'USD';

        return $options;

    }


    private function _get_data_from_post(): array
    {

        $data = $this->form_validator->_get_data_from_post(self::INPUT_FIELDS);

        $month = post('month', true);
        $data['month'] = $month < 10 ? '0'.$month : $month;

        $year = post('year', true);
        $data['year'] = $year < 10 ? '0'.$year : $year;

        return $data;
    }


    /* CAPTURE PAYMENT WITH VALIDATION AND PDF GENERATION */
    // post endpoint to capture payment data
    function submit()
    {

        $submit = post('submit');

        // post requests needs validation
        if ($submit == 'Send Money!') {

            // custom pre-processing
            $card = post('card_number', true);
            $card = preg_replace('/\s/', '', $card); // Remove all whitespace
            $_POST['card_number'] = $card;

            // rules
            $this->validation_helper->set_rules('card_number', 'Card number',
                'required|numeric|exact_length[16]');

            $this->validation_helper->set_rules('month', 'Expiration month',
                'required|numeric|exact_length[2]');

            $this->validation_helper->set_rules('year', 'Expiration year',
                'required|numeric|exact_length[2]');

            $this->validation_helper->set_rules('amount', 'Amount in HUF',
                'required|greater_than['.self::MIN.']|less_than['.self::MAX.']');

            $this->validation_helper->set_rules('cvv', 'CVV code',
                'required|min_length[3]|max_length[4]');

            $this->validation_helper->set_rules('full_name', 'Name on the card',
                'required|min_length[3]');

            $this->validation_helper->set_rules('email_address', 'Email address',
                'required|valid_email');

            $this->validation_helper->set_rules('currency_id', 'Currency',
                'required');


            // run the validation tests
            $result = $this->validation_helper->run();


            // validate card number (Luhn algorithm)
            $this->form_validator->_validate_card_number($card);

            // validate month in MM format
            $this->form_validator->_validate_expiration_month();


            // expiration validation
            $this->form_validator->_validate_card_expiration();


            // this is a workaround to be able to have custom validations that are not part of the framework
            // intentionally not using _callback prefix, validation methods are outsourced in the "A" module instead
            if ($result === true && !isset($_SESSION['form_submission_errors'])) {

                $this->to_currency = strtoupper(post('currency_id', true));
                $this->amount = post('amount', true);

                $this->full_name = post('full_name', true);
                $this->email_address = post('email_address', true);

                $this->_convert_currency();

                $message = 'Converted currency: '.$this->converted_amount.' '.$this->to_currency;
                set_flashdata($message);

                // todo: later on, the orders will be stored in the database of course
                // and the invoices will be generated using the values from the order records
                // currently the pdf is generated instantly, and a download prompt appears
                // I am just messing around with dompdf...
//                $this->get_invoice();

                $this->form();

            } else {
                $this->form();
            }

        }

    }



    /* CURRENCY CONVERSION WITH API - METHODS */

    // Convert the amount from one currency to another
    private function _convert_currency(): void
    {
        $query = $this->_construct_query();

        try {
            $json = $this->api_helper->_curl_call($query);
            $results = json_decode($json);


            if (!isset($results) || !property_exists($results, 'data')) {
                throw new Exception($results->message ?? 'Unable to fetch data from currency conversion API.');
            }

            $currency_rates = $results->data;

            // convert HUF -> USD -> EUR (example)
            $this->converted_amount = $this->amount / $currency_rates->{$this->from_currency} * $currency_rates->{$this->to_currency};
        } catch (Exception $ex) {
            $this->form_validator->_set_error($ex->getMessage());
            $this->form();
        }
    }


    /** construct the query url */
    private function _construct_query(): string
    {
        return self::API_URL.'?apikey='.self::API_KEY;
    }



    /* PDF INVOICE GENERATION METHODS */

    public function get_invoice()
    {
        $html_content = $this->_prepare_pdf_content();
        // instant download
        $this->_generate_pdf_invoice($html_content, 'Invoice', 'default', true);

    }


    private function _prepare_pdf_content(): string
    {
        $html_content = <<<HTML
<table>
    <thead>
        <tr>
            <th>Property</th>
            <th>Value</th>
        </tr>
    </thead>
        <tbody>
            <tr>
                <td>Name</td>
                <td>$this->full_name</td>
            </tr>
            <tr>
                <td>Email address</td>
                <td>$this->email_address</td>
            </tr>
            <tr>
                <td>Submitted amount</td>
                <td>$this->amount $this->from_currency</td>
            </tr>
            <tr>
                <td>Converted amount</td>
                <td>$this->converted_amount $this->to_currency</td>
            </tr>
        </tbody>
</table>
HTML;

        return $html_content;
    }


    private function _generate_pdf_invoice(string $html_content, string $title, string $template, bool $is_attachment)
    {
        $this->module('invoice');
        $this->invoice->print_invoice($html_content, $title, $template, $is_attachment);
    }

}
