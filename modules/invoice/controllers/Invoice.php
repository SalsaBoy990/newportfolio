<?php
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

class Invoice extends Trongate
{

    private \Dompdf\Dompdf $dompdf;
    private \Dompdf\Options $options;


    public function __construct($module_name = null)
    {
        parent::__construct($module_name);

        $this->options = new Options;
        $this->options->set('defaultFont', 'Courier');
        $this->options->setIsRemoteEnabled(true);

        // https://github.com/dompdf/dompdf/blob/6782abfc090b132134cd6cea0ec6d76f0fce2c56/src/Options.php#L294
        // directory where dompdf should read images
        $this->options->setChroot(realpath(__DIR__."/../assets/"));

        // instantiate and use the dompdf class
        $this->dompdf = new Dompdf($this->options);
    }

    // todo: will be removed
    public function print_pdf()
    {
        $header = 'A title...';

        $logo_path = dirname(__FILE__, 2).'/assets/images/krokodil.png';
//        $image_type = pathinfo($logo_path, PATHINFO_EXTENSION);
//        $image_data = file_get_contents($logo_path);
//        $base64_logo = 'data:image/' . $image_type . ';base64,' . base64_encode($image_data);

        $content = <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
@page {
    margin: 100px 50px;
}
#header {
    position: fixed;
    left: -50px; top: -100px; right: -50px; height: 100px;
    background-color: orange;
}
h1 {
    color: #006ce7;
}

</style>
</head>
<body>
    <div id="header">
        <img src="$logo_path" width="60" >
    </div>
    <h1>$header</h1>
</body>
</html>
HTML;

        $this->_pdf_printer($content);

    }

    public function print_invoice(
        string $html_content,
        string $title = 'Invoice',
        string $template = 'default',
        bool $is_attachment = true
    ) {


        $logo_path = dirname(__FILE__, 2).'/assets/images/krokodil.png';

        // template will be populated with the arguments received
        $content = file_get_contents(dirname(__FILE__, 2).'/templates/' . $template . '.html');

        $content = str_replace(['{{ logo_path }}', '{{ title }}', '{{ content }}'], [$logo_path, $title, $html_content], $content);


        // do the actual generation
        $this->_pdf_printer($content, 'invoice', $title, $is_attachment);

    }


    /**
     * Prints the PDF from the final, assembled html content
     *
     * attachment=1 -> download
     * attachment=0 -> show pdf viewer inside the browser
     */
    private function _pdf_printer(
        string $html_content = '',
        string $filename = 'invoice',
        string $title = 'An example invoice PDF',
        bool $is_attachment = true
    ) {
        $this->dompdf->loadHtml($html_content);
        // $this->dompdf->loadHtmlFile('template.html');

        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $this->dompdf->render();

        // Should set metadata after calling the render method (title, description, author etc.)
        $this->dompdf->addInfo('Title', $title);

        // Output the generated PDF to Browser
        $this->dompdf->stream($filename.'.pdf', [
            "Attachment" => $is_attachment ? 1 : 0
        ]);

        $output = $this->dompdf->output();
        file_put_contents(dirname(__FILE__, 2).'/assets/test.pdf', $output);
    }

}
