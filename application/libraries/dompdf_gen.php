<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter DomPDF Library
 *
 * Generate PDF's from HTML in CodeIgniter
 *
 * @packge        CodeIgniter
 * @subpackage        Libraries
 * @category        Libraries
 * @author        Ardianta Pargo
 * @license        MIT License
 * @link        https://github.com/ardianta/codeigniter-dompdf
 */
// use Dompdf\Dompdf;
// class Dompdf_gen extends Dompdf{
//     /**
//      * PDF filename
//      * @var String
//      */
    
//     public $filename;
//     public function __construct(){
//         parent::__construct();
//         $this->filename = "laporan.pdf";
//     }
//     /**
//      * Get an instance of CodeIgniter
//      *
//      * @access    protected
//      * @return    void
//      */
//     protected function ci()
//     {
//         return get_instance();
//     }
//     /**
//      * Load a CodeIgniter view into domPDF
//      *
//      * @access    public
//      * @param    string    $view The view to load
//      * @param    array    $data The view data
//      * @return    void
//      */
//     public function load_view($view, $data = array()){
//         // define("DOMPDF_ENABLE_REMOTE", false);
//         $html = $this->ci()->load->view($view, $data, TRUE);
//         $this->load_html($html);
//         // Render the PDF
//         $this->render();
//         // Output the generated PDF to Browser
//         $this->stream($this->filename, array("Attachment" => false));
//     }
// }

use Dompdf\Dompdf;
use Dompdf\Options;
class Dompdf_gen extends Dompdf{
    protected $ci;
    private $filename;

    public function __construct()
    {
       parent::__construct();
        $this->ci =& get_instance();
    }

    public function setFileName($filename)
   {
      $this->filename = $filename;
   }

   public function loadView($viewFile, $data = array())
   {  
      // require_once(APPPATH.'third_party/dompdf/autoload.inc.php');
      $options = new Options();
      // $options->setChroot(FCPATH); // Set root nya ke /var/www/html/nama-project
      $options->setDefaultFont('courier');
      // $options->setBasePath($_SERVER['DOCUMENT_ROOT']);
    //   $options->set('isRemoteEnabled', true);
      $options->setIsRemoteEnabled(true);

      $this->setOptions($options);

      $html = $this->ci->load->view($viewFile, $data, true);
      $this->loadHtml($html);
      $this->render();
      $font = $this->getFontMetrics()->get_font("helvetica", "bold");
      $this->getCanvas()->page_text(72, 18, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
      $this->stream($this->filename, ['Attachment' => 0]);
   }


}