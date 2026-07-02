<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Image_processing;
use App\Libraries\Permission;
use App\Libraries\Theme_2;
use App\Libraries\Theme_3;
use App\Libraries\Theme_default;
use App\Models\ProductsModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class Products extends BaseController
{

    protected $validation;
    protected $session;
    protected $permission;
    protected $theme_3;
    protected $theme_2;
    protected $theme_default;
    protected $imageProcessing;
    protected $crop;
    protected $productsModel;
    private $module_name = 'Products';
    private $productImageSizes = [['width' => '191', 'height' => '191'], ['width' => '198', 'height' => '198'], ['width' => '100', 'height' => '100'], ['width' => '437', 'height' => '437'], ['width' => '50', 'height' => '50'],];
    /**
     * @description This method is the constructor for the Products controller
     */
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->permission = new Permission();
        $this->crop = \Config\Services::image();
        $this->theme_3 = new Theme_3();
        $this->theme_2 = new Theme_2();
        $this->theme_default = new Theme_default();
        $this->productsModel = new ProductsModel();
        $this->imageProcessing = new Image_processing();
    }
    /**
     * @description This method provides the product create page
     * @return void
     */
    public function old_index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_products');
            $data['product'] = $table->orderBy('product_id', 'desc')->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Products/index', $data);
            } else {
                echo view('Admin/no_permission');
            }

            if (isset(newSession()->resetDatatable)) {
                unset($_SESSION['resetDatatable']);
            }
        }
    }

    /**
     * @description This method provides product create page view
     * @return RedirectResponse|void
     */
    public function create()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $protable = DB()->table('cc_products');
            $data['products'] = $protable->get()->getResult();

            $table = DB()->table('cc_product_category');
            $data['prodCat'] = $table->where('status', '1')->get()->getResult();

            $tableBrand = DB()->table('cc_brand');
            $data['brands'] = $tableBrand->where('status', 'Active')->orderBy('name', 'ASC')->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/Products/create', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }
    /**
     * @description This method provides the product create page for Gemini integration
     * @return void
     */ 
    public function create_gemini()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $protable = DB()->table('cc_products');
            $data['products'] = $protable->get()->getResult();

            $table = DB()->table('cc_product_category');
            $data['prodCat'] = $table->where('status', '1')->get()->getResult();

            $tableBrand = DB()->table('cc_brand');
            $data['brands'] = $tableBrand->where('status', 'Active')->orderBy('name', 'ASC')->get()->getResult();

            // dd(get_settings('gemini_api_key'));
            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/Products/create-gemini', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }
    /**
     * @description This method analyzes a single product image using the Gemini API
     * @return ResponseInterface
     */

    public function product_ai_analyze_batch()
    {
        $apiKey = get_lebel_by_value_in_settings('gemini_api_key');
        if (empty($apiKey)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'API Key is missing']);
        }

        $apiUrl = getenv('GEMINI_API_URL');
        $url = $apiUrl . "?key=" . $apiKey;

        $metadataInput = $this->request->getPost('metadata');
        $metadata = json_decode($metadataInput, true);
        $images = $this->request->getFileMultiple('images');
        $analyzePrompt = $this->request->getPost('analyzePrompt');
        if (empty($metadata)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Metadata is missing']);
        }

        if (empty($images)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No images were uploaded or files exceed server limits (post_max_size/upload_max_filesize)']);
        }

        $availableCategories = $this->request->getPost('available_categories');
        $availableBrands = $this->request->getPost('available_brands');
        $availableBrandsIds = array_column(json_decode($availableBrands, true), 'id');
        $parts = [
            ["text" => $this->getBatchPromptCreate($availableCategories, $availableBrands, $analyzePrompt, $metadata)]
        ];

        foreach ($images as $index => $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $parts[] = [
                    "inline_data" => [
                        "mime_type" => $file->getMimeType(),
                        "data" => base64_encode(file_get_contents($file->getTempName()))
                    ]
                ];
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid file upload for image #' . ($index + 1) . ': ' . $file->getErrorString() . ' (' . $file->getError() . ')'
                ]);
            }
        }
        $allowedIds = array_column($metadata, 'unique_id');

        $payload = [
            "contents" => [["parts" => $parts]],
            "generationConfig" => [
                "temperature" => 0.4,
                "response_mime_type" => "application/json",
                "response_schema" => [
                    "type" => "OBJECT",
                    "properties" => [
                        "products" => [
                            "type" => "ARRAY",
                            "items" => [
                                "type" => "OBJECT",
                                "properties" => [
                                    "unique_id" => [
                                        "type" => "STRING",
                                        "enum" => $allowedIds
                                    ],
                                    "name" => ["type" => "STRING"],
                                    "alt_name" => ["type" => "STRING"],
                                    "description" => ["type" => "STRING"],
                                    "price" => ["type" => "NUMBER"],
                                    "weight" => ["type" => "STRING", "description" => "Weight in kg"],
                                    "model" => ["type" => "STRING"],
                                    "tags" => ["type" => "STRING"],
                                    "meta_title" => ["type" => "STRING"],
                                    "meta_description" => ["type" => "STRING"],
                                    "meta_keyword" => ["type" => "STRING"],
                                    "category_ids" => ["type" => "ARRAY", "items" => ["type" => "INTEGER"]],
                                    "brand_id" => ["type" => "INTEGER", "enum" => $availableBrandsIds]
                                ],
                                "required" => ["unique_id", "name", "alt_name", "description", "price", "weight", "model", "tags", "meta_title", "meta_description", "meta_keyword", "category_ids", "brand_id"]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $client = \Config\Services::curlrequest();
        try {
            $response = $client->setBody(json_encode($payload))
                ->setHeader('Content-Type', 'application/json')->request('POST', $url, ['timeout' => 2000]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['error'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gemini API Error: ' . ($result['error']['message'] ?? 'Unknown API error')
                ]);
            }

            $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$responseText) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Empty response from AI']);
            }

            $decoded = json_decode($responseText, true);
            if (json_last_error() !== JSON_ERROR_NONE || !isset($decoded['products'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid AI JSON structure']);
            }
            // Re-order based on metadata unique_id
            $productMap = array_column($decoded['products'], null, 'unique_id');
            $orderedProducts = [];
            foreach ($metadata as $meta) {
                $orderedProducts[] = $productMap[$meta['unique_id']] ?? $this->getErrorProduct($meta);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'products' => $orderedProducts,
                'csrfHash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'API Connection failed: ' . $e->getMessage()]);
        }
    }
    /**
     * @description This method analyzes a single product image using the Gemini API
     * @return ResponseInterface
     */
    public function product_ai_analyze_single()
    {
        $apiKey = get_lebel_by_value_in_settings('gemini_api_key');
        if (empty($apiKey)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'API Key is missing']);
        }
        $apiUrl = getenv('GEMINI_API_URL');
        $url = $apiUrl . "?key=" . $apiKey;

        $request = service('request');
        $product_id = $request->getPost('product_id');
        $original_image = $request->getPost('original_image');

        if (empty($product_id) || empty($original_image)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Product ID and Image are required']);
        }

        $image_path = get_product_original_image_path('uploads/products', $product_id, $original_image);

        if (!$image_path || !file_exists($image_path)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Image file not found']);
        }

        $mime_type = mime_content_type($image_path);
        $availableCategories = $this->request->getPost('available_categories');

        $parts = [
            ["text" => $this->getBatchPrompt($availableCategories) . " Please analyze this single product."]
        ];

        $parts[] = [
            "inline_data" => [
                "mime_type" => $mime_type,
                "data" => base64_encode(file_get_contents($image_path))
            ]
        ];

        // UPDATED SCHEMA: Returning a single object instead of an array
        $payload = [
            "contents" => [["parts" => $parts]],
            "generationConfig" => [
                "temperature" => 0.4,
                "response_mime_type" => "application/json",
                "response_schema" => [
                    "type" => "OBJECT",
                    "properties" => [
                        "name" => ["type" => "STRING"],
                        "description" => ["type" => "HTML", "format" => "html"],
                        "price" => ["type" => "NUMBER"],
                        "weight" => ["type" => "STRING", "description" => "Weight in kg"],
                        "model" => ["type" => "STRING"],
                        "tags" => ["type" => "STRING"],
                        "meta_title" => ["type" => "STRING"],
                        "meta_description" => ["type" => "STRING"],
                        "meta_keyword" => ["type" => "STRING"],
                        "category_ids" => ["type" => "ARRAY", "items" => ["type" => "INTEGER"]]
                    ],
                    "required" => ["name", "description", "price"]
                ]
            ]
        ];

        $client = \Config\Services::curlrequest();
        try {
            $response = $client->setBody(json_encode($payload))
                ->setHeader('Content-Type', 'application/json')->request('POST', $url, ['timeout' => 30]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['error'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gemini Error: ' . $result['error']['message']]);
            }

            $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
            $productData = json_decode($responseText, true);

            if (!$productData) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to parse AI response']);
            }

            // Return single product object directly
            return $this->response->setJSON([
                'status' => 'success',
                'product' => $productData,
                'csrfHash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);
        }
    }

    /**
     * @description This method returns a default product object for failed analyses
     * @param array $meta
     * @return array
     */
    private function getErrorProduct($meta)
    {
        return [
            'unique_id' => $meta['unique_id'],
            'name' => 'Analysis Failed - ' . ($meta['file_name'] ?? 'Unknown'),
            'description' => 'AI could not analyze this image properly.',
            'price' => 0,
            'weight' => '',
            'model' => '',
            'tags' => '',
            'meta_title' => '',
            'meta_description' => '',
            'meta_keyword' => '',
            'category_ids' => []
        ];
    }
    /**
     * @description This method generates the prompt for batch product creation
     * @param array $availableCategories
     * @param array $availableBrands
     * @param string|null $analyzePrompt
     * @param array $metadata
     * @return string
     */
    private function getBatchPromptCreate($availableCategories, $availableBrands, $analyzePrompt = null, $metadata = [])
    {
        $metaInfo = '';
        if ($metadata) {
            $metaInfo = "\n\nImage return exact Metadata (use these exact unique_id):\n" .
                json_encode($metadata, JSON_PRETTY_PRINT);
        }
        return $analyzePrompt ? $analyzePrompt . "\n\n" : get_product_image_analyze_prompt() . "\n\n" . "
            Available Categories (JSON map: category_name => prod_cat_id):
            {$availableCategories}
            Available Brands (JSON map: brand_name => brand_id):
            {$availableBrands}

            - Match the brand name visible in the image/logo as closely as possible.
            - If the brand is not in the list, use the brand name that appears most similar (fuzzy match).
            - Prefer the official brand name over generic terms. Brand Selection Guidelines (Very Important):
            - If no brand is clearly visible, use the most logical brand based on product type or set `brand_id` to null.

            Return ONLY the JSON. Do not add any extra text, return the same unique_id from the metadata. explanation, or markdown." . $metaInfo;
    }
    /**
     * @description This method provides product create action
     * @return RedirectResponse
     */
    private function getBatchPromptUpdate($availableCategories, $availableBrands, $analyzePrompt = null, $metadata = [])
    {
        $metaInfo = '';
        if (!empty($metadata)) {
            $metaInfo = "\n\n[IMAGE ARRAY TO DATABASE ID MAP]:\n";
            $metaInfo .= "You are being passed an array of images. Map them sequentially to these objects:\n";
            foreach ($metadata as $index => $meta) {
                // Added original image filename reference to help the model match contextually
                $metaInfo .= "- Image index {$index} filename is \"{$meta['image']}\" matches Database ID: \"{$meta['unique_id']}\" (Current Price Reference: {$meta['current_price']}, Current Brand Name Reference: {$meta['current_brand_name']} if N/A return 'N/A' instead)\n";
            }
            $metaInfo .= "\nCRITICAL RULE: For every processed product, set 'unique_id' EXACTLY to its matching Database ID string from the list above. Do NOT generate alphanumeric text slugs.
            ";
        }

        return $analyzePrompt . "\n\n" . "{$metaInfo}
    Available Categories (JSON map: category_name => prod_cat_id):
    {$availableCategories}
    
    Available Brands (JSON map: brand_name => brand_id):
    {$availableBrands}
   
    Response Instruction: Return ONLY the JSON adhering to your schema. Do not add markdown wrapping like ```json or trailing explanations. description should be HTML format not &lt;p&gt; user < >.";
    }

    /**
     * @description This method provides product create action
     * @return RedirectResponse
     */
    private function getBatchPrompt($availableCategories, $metadata = [])
    {
        $metaInfo = '';
        if ($metadata) {
            $metaInfo = "\n\nImage Metadata (use these unique_id):\n" .
                json_encode($metadata, JSON_PRETTY_PRINT);
        }
        return "You are an expert e-commerce product analyst and SEO specialist.
            Analyze the uploaded product image(s) carefully and extract accurate product information.
            Rules:
            - Analyze every image separately and create one product object per image.
            - Be precise with price (realistic market price).
            - Weight should include unit.
            - Tags should be comma-separated relevant keywords.
            - Meta Title should be catchy and SEO-friendly (under 60 characters).
            - Meta Description should be persuasive and contain main keywords.
            - For category_ids: ONLY use IDs from the available categories list below. Choose the most relevant one or more (maximum 3).
            - If unsure about a category, choose the closest match.
            Available Categories (JSON):
            {$availableCategories}

            Return ONLY the JSON. Do not add any extra text, explanation, or markdown." . $metaInfo;
    }
    /**
     * @description This method provides product create action
     * @return RedirectResponse
     */
    public function create_batch_gemini_action()
    {
        $adUserId = $this->session->adUserId;
        $batch = $this->request->getPost('batch');
        $files = $this->request->getFiles();

        if (empty($batch)) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger">No products to save.</div>');
            return redirect()->to('product_create_gemini');
        }

        $this->validation->setRules([
            'batch.*.name' => ['label' => 'Name', 'rules' => 'required'],
            'batch.*.model' => ['label' => 'Model', 'rules' => 'required'],
            'batch.*.category_ids.*' => ['label' => 'Category', 'rules' => 'required'],
            'batch.*.price' => ['label' => 'Price', 'rules' => 'required'],
            'batch.*.quantity' => ['label' => 'Quantity', 'rules' => 'required|is_natural_no_zero'],
        ]);


        if ($this->validation->withRequest($this->request)->run() == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('product_create_gemini');
        }

        $createdDirs = [];
        try {
            DB()->transStart();
            foreach ($batch as $i => $p) {
                // 1. Insert Product
                $proData = [
                    'store_id' => get_data_by_id('store_id', 'cc_stores', 'is_default', '1'),
                    'name' => $p['name'],
                    'alt_name' => $p['alt_name'] ?? '',
                    'price' => $p['price'],
                    'model' => $p['model'],
                    'quantity' => $p['quantity'],
                    'weight' => $p['weight'] ?? '',
                    'brand_id' => $p['brand_id'] ?? '',
                    'status' => 1,
                    'createdBy' => $adUserId
                ];
                DB()->table('cc_products')->insert($proData);
                $productId = DB()->insertID();

                // 2. Handle Image

                $pic = $files['batch'][$i]['image'];

                if ($pic && $pic->isValid() && !$pic->hasMoved()) {
                    $target_dir = FCPATH . 'uploads/products/' . $productId . '/';
                    $createdDirs[] = $target_dir;
                    $this->imageProcessing->directory_create($target_dir);
                    $news_img = $this->imageProcessing->product_image_upload_and_crop_all_size($pic, $target_dir);
                    DB()->table('cc_products')->where('product_id', $productId)->update(['image' => $news_img]);
                }

                // 3. Description
                DB()->table('cc_product_description')->insert([
                    'product_id' => $productId,
                    'description' => $p['description'] ?? '',
                    'meta_title' => $p['meta_title'] ?? '',
                    'meta_description' => $p['meta_description'] ?? '',
                    'meta_keyword' => $p['meta_keyword'] ?? '',
                    'tag' => $p['tags'] ?? '',
                    'createdBy' => $adUserId
                ]);

                // 4. Categories
                $catData = array_map(fn($catId) => [
                    'product_id' => $productId,
                    'category_id' => $catId
                ], $p['category_ids']);
                DB()->table('cc_product_to_category')->insertBatch($catData);
            }
            DB()->transComplete();

            if (DB()->transStatus() === false) {
                throw new \Exception("Transaction failed");
            }

            $this->session->setFlashdata('message', '<div class="alert alert-success">Batch products created successfully!</div>');
            return redirect()->to('product_create_gemini');
        } catch (\Throwable $e) {
            DB()->transRollback();
            foreach ($createdDirs as $dir) {
                if (is_dir($dir)) {
                    $this->imageProcessing->deleteDirectory($dir);
                }
            }
            $this->session->setFlashdata('message', '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>');
            return redirect()->to('product_create_gemini');
        }
    }
    /**
     * @description This method provides product create action for single product
     * @return ResponseInterface
     */
    public function product_create_gemini_action()
    {
        // Restrict access strictly to AJAX POST interactions
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'status'  => 'error',
                'message' => 'Direct script access is not allowed.'
            ]);
        }

        $adUserId = $this->session->adUserId;
        $files    = $this->request->getFiles();

        // 1. Capture individual flat POST parameters from form submission
        $name            = $this->request->getPost('name');
        $alt_name        = $this->request->getPost('alt_name') ?? '';
        $model           = $this->request->getPost('model') ?? '';
        $price           = $this->request->getPost('price');
        $quantity        = $this->request->getPost('quantity');
        $brand_id         = $this->request->getPost('brand_id') ?? '';
        $weight          = $this->request->getPost('weight') ?? '';
        $description     = $this->request->getPost('description') ?? '';
        $category_ids    = $this->request->getPost('categorys') ?? []; // mapped to 'categorys[]' in HTML
        $tags            = $this->request->getPost('tags') ?? '';
        $meta_title      = $this->request->getPost('meta_title') ?? '';
        $meta_description = $this->request->getPost('meta_description') ?? '';
        $meta_keyword    = $this->request->getPost('meta_keyword') ?? '';

        // 2. Validate single incoming product model values
        $this->validation->setRules([
            'name'         => ['label' => 'Name', 'rules' => 'required'],
            'alt_name'     => ['label' => 'Alt Name', 'rules' => 'required'],
            'price'        => ['label' => 'Price', 'rules' => 'required|numeric'],
            'quantity'     => ['label' => 'Quantity', 'rules' => 'required|is_natural_no_zero'],
            'categorys'    => ['label' => 'Category', 'rules' => 'required'],
            'description'  => ['label' => 'Description', 'rules' => 'required'],
        ]);

        // Construct validation matching data array signatures
        $validationData = [
            'name'         => $name,
            'alt_name'     => $alt_name,
            'price'        => $price,
            'quantity'     => $quantity,
            'categorys'    => $category_ids,
            'description'  => $description
        ];

        if ($this->validation->run($validationData) === false) {
            return $this->response->setJSON([
                'status'    => 'validation_error',
                'message'   => $this->validation->listErrors(),
                'csrf_hash' => csrf_hash() // Send back fresh token regeneration string
            ]);
        }

        $target_dir = '';
        try {
            DB()->transStart();

            // 3. Insert Database Entry into Core Product Table
            $proData = [
                'store_id'  => get_data_by_id('store_id', 'cc_stores', 'is_default', '1'),
                'name'      => $name,
                'alt_name'  => $alt_name,
                'price'     => $price,
                'brand_id'  => $brand_id,
                'model'     => $model,
                'quantity'  => $quantity,
                'weight'    => $weight,
                'status'    => 1,
                'createdBy' => $adUserId
            ];
            DB()->table('cc_products')->insert($proData);
            $productId = DB()->insertID();

            // 4. Extract single file uploaded pointer
            $pic = $files['image'] ?? null; // maps to <input type="file" name="image">

            if ($pic && $pic->isValid() && !$pic->hasMoved()) {
                $target_dir = FCPATH . 'uploads/products/' . $productId . '/';
                $this->imageProcessing->directory_create($target_dir);
                $news_img = $this->imageProcessing->product_image_upload_and_crop_all_size($pic, $target_dir);
                DB()->table('cc_products')->where('product_id', $productId)->update(['image' => $news_img]);
            }

            // 5. Insert Details to Text Descriptions Table
            DB()->table('cc_product_description')->insert([
                'product_id'       => $productId,
                'description'      => $description,
                'meta_title'       => $meta_title,
                'meta_description' => $meta_description,
                'meta_keyword'     => $meta_keyword,
                'tag'              => $tags,
                'createdBy'        => $adUserId
            ]);

            // 6. Bind Product Categories Links
            if (!empty($category_ids)) {
                $catData = array_map(fn($catId) => [
                    'product_id'  => $productId,
                    'category_id' => $catId
                ], $category_ids);
                DB()->table('cc_product_to_category')->insertBatch($catData);
            }

            DB()->transComplete();

            if (DB()->transStatus() === false) {
                throw new \Exception("Database transaction failure processing record.");
            }

            return $this->response->setJSON([
                'status'    => 'success',
                'message'   => 'Product <strong>' . esc($name) . '</strong> created successfully.',
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Throwable $e) {
            DB()->transRollback();

            // Clean out garbage files system directory structure pathing allocations on exceptions
            if (!empty($target_dir) && is_dir($target_dir)) {
                $this->imageProcessing->deleteDirectory($target_dir);
            }

            return $this->response->setJSON([
                'status'    => 'error',
                'message'   => 'Creation breakdown: ' . $e->getMessage(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }
    /**
     * @description This method provides product create action
     * @return RedirectResponse
     */
    public function create_action()
    {

        $adUserId = $this->session->adUserId;

        $data['pro_name'] = $this->request->getPost('pro_name');
        $data['model'] = $this->request->getPost('model');
        $data['categorys'] = $this->request->getPost('categorys[]');
        $data['price'] = $this->request->getPost('price');
        $data['quantity'] = $this->request->getPost('quantity');

        $this->validation->setRules([
            'pro_name' => ['label' => 'Name', 'rules' => 'required'],
            'model' => ['label' => 'Model', 'rules' => 'required'],
            'categorys' => ['label' => 'Category', 'rules' => 'required'],
            'price' => ['label' => 'Price', 'rules' => 'required'],
            'quantity' => ['label' => 'Quantity', 'rules' => 'required|is_natural_no_zero'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('product_create');
        } else {
            DB()->transStart();

            //product table data insert(start)
            $storeId = get_data_by_id('store_id', 'cc_stores', 'is_default', '1');
            $proData['store_id'] = $storeId;
            $proData['name'] = $data['pro_name'];
            $proData['alt_name'] = $data['pro_name'];
            $proData['model'] = $data['model'];
            $proData['brand_id'] = !empty($this->request->getPost('brand_id')) ? $this->request->getPost('brand_id') : null;
            $proData['price'] = $data['price'];
            $proData['weight'] = $this->request->getPost('weight');
            $proData['length'] = $this->request->getPost('length');
            $proData['width'] = $this->request->getPost('width');
            $proData['height'] = $this->request->getPost('height');
            $proData['sort_order'] = $this->request->getPost('sort_order');
            $proData['status'] = $this->request->getPost('status');
            $proData['quantity'] = $this->request->getPost('quantity');
            $proData['createdBy'] = $adUserId;

            $product_featured = $this->request->getPost('product_featured');
            if ($product_featured == 'on') {
                $proData['featured'] = '1';
            }

            $proTable = DB()->table('cc_products');
            $proTable->insert($proData);
            $productId = DB()->insertID();


            if (!empty($_FILES['image']['name'])) {
                $target_dir = FCPATH . '/uploads/products/' . $productId . '/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $pic = $this->request->getFile('image');
                $news_img = $this->imageProcessing->product_image_upload_and_crop_all_size($pic, $target_dir);

                $dataImg['image'] = $news_img;

                $proUpTable = DB()->table('cc_products');
                $proUpTable->where('product_id', $productId)->update($dataImg);
            }
            //product table data insert(end)


            //multi image upload(start)
            if ($this->request->getFileMultiple('multiImage')) {

                $target_dir = FCPATH . '/uploads/products/' . $productId . '/';
                $this->imageProcessing->directory_create($target_dir);

                $files = $this->request->getFileMultiple('multiImage');
                foreach ($files as $file) {

                    if ($file->isValid() && !$file->hasMoved()) {
                        $dataMultiImg['product_id'] = $productId;
                        $dataMultiImg['alt_name'] = $data['pro_name'];
                        $proImgTable = DB()->table('cc_product_image');
                        $proImgTable->insert($dataMultiImg);
                        $proImgId = DB()->insertID();

                        $target_dir2 = FCPATH . '/uploads/products/' . $productId . '/' . $proImgId . '/';
                        $this->imageProcessing->directory_create($target_dir2);

                        $news_img2 = $this->imageProcessing->product_image_upload_and_crop_all_size($file, $target_dir2);

                        $dataMultiImg2['image'] = $news_img2;

                        $proImgUpTable = DB()->table('cc_product_image');
                        $proImgUpTable->where('product_image_id', $proImgId)->update($dataMultiImg2);
                    }
                }
            }
            //multi image upload(start)


            //product category insert(start)
            $catData = [];
            foreach ($data['categorys'] as $key => $cat) {
                $catData[$key] = [
                    'product_id' => $productId,
                    'category_id' => $cat,
                ];
            }
            $catTable = DB()->table('cc_product_to_category');
            $catTable->insertBatch($catData);
            //product category insert(end)


            //product_free_delivery data insert(start)
            $free_delivery = $this->request->getPost('product_free_delivery');
            if ($free_delivery == 'on') {
                $proFreeData['product_id'] = $productId;
                $proFreetable = DB()->table('cc_product_free_delivery');
                $proFreetable->insert($proFreeData);
            }
            //product_free_delivery data insert(end)


            //product description table data insert(start)
            $proDescData['product_id'] = $productId;
            $proDescData['description'] = !empty($this->request->getPost('description')) ? $this->request->getPost('description') : null;
            $proDescData['tag'] = !empty($this->request->getPost('tag')) ? $this->request->getPost('tag') : null;
            $proDescData['meta_title'] = !empty($this->request->getPost('meta_title')) ? $this->request->getPost('meta_title') : null;
            $proDescData['meta_description'] = !empty($this->request->getPost('meta_description')) ? $this->request->getPost('meta_description') : null;
            $proDescData['meta_keyword'] = !empty($this->request->getPost('meta_keyword')) ? $this->request->getPost('meta_keyword') : null;
            $proDescData['video'] = !empty($this->request->getPost('video')) ? $this->request->getPost('video') : null;
            $proDescData['createdBy'] = $adUserId;


            if (!empty($_FILES['description_image']['name'])) {
                $target_dir = FCPATH . '/uploads/products/' . $productId . '/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $despic = $this->request->getFile('description_image');
                $namePic = 'des_' . $despic->getRandomName();
                $despic->move($target_dir, $namePic);

                $proDescData['description_image'] = $namePic;
            }

            if (!empty($_FILES['documentation_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/' . $productId . '/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $docPdf = $this->request->getFile('documentation_pdf');
                $nameDoc = 'doc_' . $docPdf->getRandomName();
                $docPdf->move($target_dir, $nameDoc);

                $proDescData['documentation_pdf'] = $nameDoc;
            }

            if (!empty($_FILES['safety_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/' . $productId . '/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $safPdf = $this->request->getFile('safety_pdf');
                $nameDoc = 'saf_' . $safPdf->getRandomName();
                $safPdf->move($target_dir, $nameDoc);

                $proDescData['safety_pdf'] = $nameDoc;
            }

            if (!empty($_FILES['instructions_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/' . $productId . '/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $insPdf = $this->request->getFile('instructions_pdf');
                $nameDoc = 'ins_' . $insPdf->getRandomName();
                $insPdf->move($target_dir, $nameDoc);

                $proDescData['instructions_pdf'] = $nameDoc;
            }

            $proDescTable = DB()->table('cc_product_description');
            $proDescTable->insert($proDescData);
            //product description table data insert(end)


            $option = $this->request->getPost('option[]');
            $opValue = $this->request->getPost('opValue[]');
            $qty = $this->request->getPost('qty[]');
            $subtract = $this->request->getPost('subtract[]');
            $price_op = $this->request->getPost('price_op[]');
            if (!empty($qty)) {
                $optionData = [];
                foreach ($qty as $key => $val) {
                    $optionData[$key] = [
                        'product_id' => $productId,
                        'option_id' => $option[$key],
                        'option_value_id' => $opValue[$key],
                        'quantity' => $qty[$key],
                        'subtract' => ($subtract[$key] == 'plus') ? null : 1,
                        'price' => $price_op[$key],
                    ];
                }
                $optionTable = DB()->table('cc_product_option');
                $optionTable->insertBatch($optionData);
            }
            //product options table data insert(end)


            //product Attribute table data insert(start)
            $attribute_group_id = $this->request->getPost('attribute_group_id[]');
            $name = $this->request->getPost('name[]');
            $details = $this->request->getPost('details[]');

            if (!empty($attribute_group_id)) {
                $attributeData = [];
                foreach ($attribute_group_id as $key => $val) {
                    $attributeData[$key] = [
                        'product_id' => $productId,
                        'attribute_group_id' => $attribute_group_id[$key],
                        'name' => $name[$key],
                        'details' => $details[$key],
                    ];
                }
                $attributeTable = DB()->table('cc_product_attribute');
                $attributeTable->insertBatch($attributeData);
            }

            //product Attribute table data insert(end)


            //product product_special table data insert(start)
            $special_price = $this->request->getPost('special_price');
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');

            if (!empty($special_price)) {
                $specialData['product_id'] = $productId;
                $specialData['special_price'] = $special_price;
                $specialData['start_date'] = $start_date;
                $specialData['end_date'] = $end_date;

                $specialTable = DB()->table('cc_product_special');
                $specialTable->insert($specialData);
            }
            //product product_special table data insert(end)


            //product_related table data insert(start)
            $product_related = $this->request->getPost('product_related[]');
            if (!empty($product_related)) {
                $proRelData = [];
                foreach ($product_related as $key => $relp) {
                    $proRelData[$key] = [
                        'product_id' => $productId,
                        'related_id' => $relp,
                    ];
                }
                $proReltable = DB()->table('cc_product_related');
                $proReltable->insertBatch($proRelData);
            }
            //product_related table data insert(end)


            // product_bought_together table data insert(start)
            $bought_together = $this->request->getPost('bought_together[]');
            if (!empty($bought_together)) {
                $proBothData = [];
                foreach ($bought_together as $key => $bothp) {
                    $proBothData[$key] = [
                        'product_id' => $productId,
                        'related_id' => $bothp,
                    ];
                }
                $proBothtable = DB()->table('cc_product_bought_together');
                $proBothtable->insertBatch($proBothData);
            }
            //product_bought_together table data insert(end)


            DB()->transComplete();
            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Products Create Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('product_create');
        }
    }

    /**
     * @description This method provides product copy action
     * @return RedirectResponse
     */
    public function copy_action()
    {
        $allProductId = $this->request->getPost('productId[]');


        $adUserId = $this->session->adUserId;

        if (!empty($allProductId)) {

            DB()->transStart();
            foreach ($allProductId as $p) {
                $tablePro = DB()->table('cc_products');
                $pro = $tablePro->where('product_id', $p)->get()->getRow();

                //product table data insert(start)
                $storeId = get_data_by_id('store_id', 'cc_stores', 'is_default', '1');
                $proData['store_id'] = $storeId;
                $proData['name'] = 'Copy of ' . $pro->name;
                $proData['model'] = $pro->model;
                $proData['brand_id'] = !empty($pro->brand_id) ? $pro->brand_id : null;
                $proData['price'] = $pro->price;
                $proData['weight'] = $pro->weight;
                $proData['length'] = $pro->length;
                $proData['width'] = $pro->width;
                $proData['height'] = $pro->height;
                $proData['sort_order'] = $pro->sort_order;
                $proData['status'] = 'Inactive';
                $proData['quantity'] = $pro->quantity;
                $proData['featured'] = $pro->featured;
                $proData['createdBy'] = $adUserId;

                $proTable = DB()->table('cc_products');
                $proTable->insert($proData);
                $productId = DB()->insertID();


                //product category insert(start)
                $cTable = DB()->table('cc_product_to_category');
                $categ = $cTable->where('product_id', $p)->get()->getResult();
                $catData = [];
                foreach ($categ as $key => $cat) {
                    $catData[$key] = [
                        'product_id' => $productId,
                        'category_id' => $cat->category_id,
                    ];
                }
                $catTable = DB()->table('cc_product_to_category');
                $catTable->insertBatch($catData);
                //product category insert(end)


                //product_free_delivery data insert(start)
                $proFrDetable = DB()->table('cc_product_free_delivery');
                $free_delivery = $proFrDetable->where('product_id', $p)->countAllResults();
                if (!empty($free_delivery)) {
                    $proFreeData['product_id'] = $productId;
                    $proFreetable = DB()->table('cc_product_free_delivery');
                    $proFreetable->insert($proFreeData);
                }
                //product_free_delivery data insert(end)


                //product description table data insert(start)
                $proDescTableget = DB()->table('cc_product_description');
                $des = $proDescTableget->where('product_id', $p)->get()->getRow();

                $proDescData['product_id'] = $productId;
                $proDescData['description'] = !empty($des->description) ? $des->description : null;
                $proDescData['tag'] = !empty($des->tag) ? $des->tag : null;
                $proDescData['meta_title'] = !empty($des->meta_title) ? $des->meta_title : null;
                $proDescData['meta_description'] = !empty($des->meta_description) ? $des->meta_description : null;
                $proDescData['meta_keyword'] = !empty($des->meta_keyword) ? $des->meta_keyword : null;
                $proDescData['video'] = !empty($des->video) ? $des->video : null;
                $proDescData['createdBy'] = $adUserId;


                $proDescTable = DB()->table('cc_product_description');
                $proDescTable->insert($proDescData);
                //product description table data insert(end)


                $optionTableGet = DB()->table('cc_product_option');
                $optData = $optionTableGet->where('product_id', $p)->get()->getResult();
                if (!empty($optData)) {
                    $optionData = [];
                    foreach ($optData as $key => $valOp) {
                        $optionData[$key] = [
                            'product_id' => $productId,
                            'option_id' => $valOp->option_id,
                            'option_value_id' => $valOp->option_value_id,
                            'quantity' => $valOp->quantity,
                            'subtract' => $valOp->subtract,
                            'price' => $valOp->price,
                        ];
                    }
                    $optionTable = DB()->table('cc_product_option');
                    $optionTable->insertBatch($optionData);
                }

                //product options table data insert(end)


                //product Attribute table data insert(start)
                $attributeTableget = DB()->table('cc_product_attribute');
                $attData = $attributeTableget->where('product_id', $p)->get()->getResult();
                if (!empty($attData)) {
                    $attributeData = [];
                    foreach ($attData as $key => $valAtt) {
                        $attributeData[$key] = [
                            'product_id' => $productId,
                            'attribute_group_id' => $valAtt->attribute_group_id,
                            'name' => $valAtt->name,
                            'details' => $valAtt->details,
                        ];
                    }
                    $attributeTable = DB()->table('cc_product_attribute');
                    $attributeTable->insertBatch($attributeData);
                }

                //product Attribute table data insert(end)


                //product product_special table data insert(start)
                $specialTableGet = DB()->table('cc_product_special');
                $spec = $specialTableGet->where('product_id', $p)->get()->getRow();
                if (!empty($spec)) {
                    $specialData['product_id'] = $productId;
                    $specialData['special_price'] = $spec->special_price;
                    $specialData['start_date'] = $spec->start_date;
                    $specialData['end_date'] = $spec->end_date;

                    $specialTable = DB()->table('cc_product_special');
                    $specialTable->insert($specialData);
                }
                //product product_special table data insert(end)


                //product_related table data insert(start)
                $proReltableGet = DB()->table('cc_product_related');
                $proReltableGetData = $proReltableGet->where('product_id', $p)->get()->getResult();
                if (!empty($proReltableGetData)) {
                    $proRelData = [];
                    foreach ($proReltableGetData as $key => $relp) {
                        $proRelData[$key] = [
                            'product_id' => $productId,
                            'related_id' => $relp->related_id,
                        ];
                    }
                    $proReltable = DB()->table('cc_product_related');
                    $proReltable->insertBatch($proRelData);
                }
                //product_related table data insert(end)


                // product_bought_together table data insert(start)
                $proBothtableGet = DB()->table('cc_product_bought_together');
                $proBothtableGetData = $proBothtableGet->where('product_id', $p)->get()->getResult();
                if (!empty($proBothtableGetData)) {
                    $proBothData = [];
                    foreach ($proBothtableGetData as $key => $bothp) {
                        $proBothData[$key] = [
                            'product_id' => $productId,
                            'related_id' => $bothp->related_id,
                        ];
                    }
                    $proBothtable = DB()->table('cc_product_bought_together');
                    $proBothtable->insertBatch($proBothData);
                }
                //product_bought_together table data insert(end)
            }
            DB()->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Products Copy Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('products?page=1');
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->back();
        }
    }

    /**
     * @description This method provides product update page view
     * @param int $product_id
     * @return RedirectResponse|void
     */
    public function update($product_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_products');
            $table->select('cc_products.*, cc_product_description.*,cc_product_description.alt_name AS altDes ,cc_products.alt_name AS altPro');
            $table->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id ');
            $data['prod'] = $table->where('cc_products.product_id', $product_id)->get()->getRow();

            $table = DB()->table('cc_product_category');
            $data['prodCat'] = $table->where('status', '1')->get()->getResult();

            $tableBrand = DB()->table('cc_brand');
            $data['brands'] = $tableBrand->where('status', 'Active')->orderBy('name', 'ASC')->get()->getResult();

            $tablecat = DB()->table('cc_product_to_category');
            $data['prodCatSel'] = $tablecat->where('product_id', $product_id)->get()->getResult();

            $tablefreeDel = DB()->table('cc_product_free_delivery');
            $data['free_delivery'] = $tablefreeDel->where('product_id', $product_id)->countAllResults();

            $tableOpti = DB()->table('cc_product_option');
            $data['prodOption'] = $tableOpti->where('product_id', $product_id)->groupBy('option_id')->get()->getResult();

            $tableAttr = DB()->table('cc_product_attribute');
            $data['prodattribute'] = $tableAttr->where('product_id', $product_id)->get()->getResult();

            $tableSpec = DB()->table('cc_product_special');
            $data['prodspecial'] = $tableSpec->where('product_id', $product_id)->get()->getRow();

            $tableimg = DB()->table('cc_product_image');
            $data['prodimage'] = $tableimg->where('product_id', $product_id)->get()->getResult();

            $tableRel = DB()->table('cc_product_related');
            $data['prodrelated'] = $tableRel->where('product_id', $product_id)->get()->getResult();

            $tableBoth = DB()->table('cc_product_bought_together');
            $data['prodBothTog'] = $tableBoth->where('product_id', $product_id)->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Products/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides product update action
     * @return RedirectResponse
     */
    public function update_action()
    {

        $adUserId = $this->session->adUserId;

        $product_id = $this->request->getPost('product_id');

        $data['pro_name'] = $this->request->getPost('pro_name');
        $data['alt_name'] = $this->request->getPost('alt_name');
        $data['model'] = $this->request->getPost('model');
        $data['categorys'] = $this->request->getPost('categorys[]');
        $data['price'] = $this->request->getPost('price');
        $data['quantity'] = $this->request->getPost('quantity');

        $this->validation->setRules([
            'pro_name' => ['label' => 'Name', 'rules' => 'required'],
            'model' => ['label' => 'Model', 'rules' => 'required'],
            'categorys' => ['label' => 'Category', 'rules' => 'required'],
            'price' => ['label' => 'Price', 'rules' => 'required'],
            'quantity' => ['label' => 'Quantity', 'rules' => 'required|is_natural_no_zero'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('product_update/' . $product_id);
        } else {
            DB()->transStart();

            //product table data insert(start)
            $proData['name'] = $data['pro_name'];
            $proData['alt_name'] = $data['alt_name'];
            $proData['model'] = $data['model'];
            $proData['brand_id'] = !empty($this->request->getPost('brand_id')) ? $this->request->getPost('brand_id') : null;
            $proData['price'] = $data['price'];
            $proData['weight'] = $this->request->getPost('weight');
            $proData['length'] = $this->request->getPost('length');
            $proData['width'] = $this->request->getPost('width');
            $proData['height'] = $this->request->getPost('height');
            $proData['sort_order'] = $this->request->getPost('sort_order');
            $proData['status'] = $this->request->getPost('status');
            $proData['quantity'] = $this->request->getPost('quantity');

            $product_featured = $this->request->getPost('product_featured');
            if ($product_featured == 'on') {
                $proData['featured'] = '1';
            } else {
                $proData['featured'] = '0';
            }

            $proTable = DB()->table('cc_products');
            $proTable->where('product_id', $product_id)->update($proData);


            if (!empty($_FILES['image']['name'])) {
                $target_dir = FCPATH . '/uploads/products/' . $product_id . '/';

                //unlink
                $oldImg = get_data_by_id('image', 'cc_products', 'product_id', $product_id);
                $pic = $this->request->getFile('image');
                $news_img = $this->imageProcessing->single_product_image_unlink($target_dir, $oldImg)->directory_create($target_dir)->product_image_upload_and_crop_all_size($pic, $target_dir);

                $dataImg['image'] = $news_img;

                $proUpTable = DB()->table('cc_products');
                $proUpTable->where('product_id', $product_id)->update($dataImg);
            }
            //product table data insert(end)


            //multi image upload(start)
            if ($this->request->getFileMultiple('multiImage')) {

                $target_dir = FCPATH . '/uploads/products/' . $product_id . '/';
                $this->imageProcessing->directory_create($target_dir);

                $files = $this->request->getFileMultiple('multiImage');
                foreach ($files as $key => $file) {

                    if ($file->isValid() && !$file->hasMoved()) {
                        $dataMultiImg['product_id'] = $product_id;
                        $dataMultiImg['alt_name'] = $data['alt_name'];
                        $proImgTable = DB()->table('cc_product_image');
                        $proImgTable->insert($dataMultiImg);
                        $proImgId = DB()->insertID();

                        $target_dir2 = FCPATH . '/uploads/products/' . $product_id . '/' . $proImgId . '/';
                        $news_img2 = $this->imageProcessing->directory_create($target_dir2)->product_image_upload_and_crop_all_size($file, $target_dir2);

                        $dataMultiImg2['image'] = $news_img2;

                        $proImgUpTable = DB()->table('cc_product_image');
                        $proImgUpTable->where('product_image_id', $proImgId)->update($dataMultiImg2);
                    }
                }
            }
            //multi image upload(start)


            //product category insert(start)
            $catTableDel = DB()->table('cc_product_to_category');
            $catTableDel->where('product_id', $product_id)->delete();
            $catData = [];
            foreach ($data['categorys'] as $key => $cat) {
                $catData[$key] = [
                    'product_id' => $product_id,
                    'category_id' => $cat,
                ];
            }
            $catTable = DB()->table('cc_product_to_category');
            $catTable->insertBatch($catData);
            //product category insert(end)


            //product_free_delivery data insert(start)
            $free_delivery = $this->request->getPost('product_free_delivery');
            if ($free_delivery == 'on') {
                if (is_exists('cc_product_free_delivery', 'product_id', $product_id) == true) {
                    $proFreeData['product_id'] = $product_id;
                    $proFreetable = DB()->table('cc_product_free_delivery');
                    $proFreetable->insert($proFreeData);
                }
            } else {
                if (is_exists('cc_product_free_delivery', 'product_id', $product_id) == false) {
                    $proFreetable = DB()->table('cc_product_free_delivery');
                    $proFreetable->where('product_id', $product_id)->delete();
                }
            }
            //product_free_delivery data insert(end)


            //product description table data insert(start)
            $proDescData['product_id'] = $product_id;
            $proDescData['description'] = !empty($this->request->getPost('description')) ? $this->request->getPost('description') : null;
            $proDescData['alt_name'] = !empty($this->request->getPost('alt_name_des')) ? $this->request->getPost('alt_name_des') : null;
            $proDescData['tag'] = !empty($this->request->getPost('tag')) ? $this->request->getPost('tag') : null;
            $proDescData['meta_title'] = !empty($this->request->getPost('meta_title')) ? $this->request->getPost('meta_title') : null;
            $proDescData['meta_description'] = !empty($this->request->getPost('meta_description')) ? $this->request->getPost('meta_description') : null;
            $proDescData['meta_keyword'] = !empty($this->request->getPost('meta_keyword')) ? $this->request->getPost('meta_keyword') : null;
            $proDescData['video'] = !empty($this->request->getPost('video')) ? $this->request->getPost('video') : null;


            if (!empty($_FILES['description_image']['name'])) {
                $target_dir = FCPATH . '/uploads/products/' . $product_id . '/';
                $this->imageProcessing->directory_create($target_dir);

                //unlink
                $oldImg = get_data_by_id('description_image', 'cc_product_description', 'product_id', $product_id);
                if ((!empty($oldImg)) && (file_exists($target_dir))) {
                    $this->imageProcessing->image_unlink($target_dir . '/' . $oldImg);
                }


                //new image upload
                $despic = $this->request->getFile('description_image');
                $namePic = 'des_' . $despic->getRandomName();
                $despic->move($target_dir, $namePic);

                $proDescData['description_image'] = $namePic;
            }

            if (!empty($_FILES['documentation_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/' . $product_id . '/';
                $this->imageProcessing->directory_create($target_dir);

                //unlink
                $oldImg = get_data_by_id('documentation_pdf', 'cc_product_description', 'product_id', $product_id);
                if ((!empty($oldImg)) && (file_exists($target_dir))) {
                    $this->imageProcessing->image_unlink($target_dir . '/' . $oldImg);
                }

                //new image upload
                $docPdf = $this->request->getFile('documentation_pdf');
                $nameDoc = 'doc_' . $docPdf->getRandomName();
                $docPdf->move($target_dir, $nameDoc);

                $proDescData['documentation_pdf'] = $nameDoc;
            }

            if (!empty($_FILES['safety_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/' . $product_id . '/';
                $this->imageProcessing->directory_create($target_dir);

                //unlink
                $oldImg = get_data_by_id('safety_pdf', 'cc_product_description', 'product_id', $product_id);
                if ((!empty($oldImg)) && (file_exists($target_dir))) {
                    $this->imageProcessing->image_unlink($target_dir . '/' . $oldImg);
                }

                //new image upload
                $safPdf = $this->request->getFile('safety_pdf');
                $nameDoc = 'saf_' . $safPdf->getRandomName();
                $safPdf->move($target_dir, $nameDoc);

                $proDescData['safety_pdf'] = $nameDoc;
            }

            if (!empty($_FILES['instructions_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/' . $product_id . '/';
                $this->imageProcessing->directory_create($target_dir);

                //unlink
                $oldImg = get_data_by_id('instructions_pdf', 'cc_product_description', 'product_id', $product_id);
                if ((!empty($oldImg)) && (file_exists($target_dir))) {
                    $this->imageProcessing->image_unlink($target_dir . '/' . $oldImg);
                }

                //new image upload
                $insPdf = $this->request->getFile('instructions_pdf');
                $nameDoc = 'ins_' . $insPdf->getRandomName();
                $insPdf->move($target_dir, $nameDoc);

                $proDescData['instructions_pdf'] = $nameDoc;
            }

            $proDescTable = DB()->table('cc_product_description');
            $proDescTable->where('product_id', $product_id)->update($proDescData);
            //product description table data insert(end)


            $option = $this->request->getPost('option[]');
            $opValue = $this->request->getPost('opValue[]');
            $qty = $this->request->getPost('qty[]');
            $subtract = $this->request->getPost('subtract[]');
            $price_op = $this->request->getPost('price_op[]');

            $optionTableDel = DB()->table('cc_product_option');
            $optionTableDel->where('product_id', $product_id)->delete();

            if (!empty($qty)) {
                $optionData = [];
                foreach ($qty as $key => $val) {
                    $optionData[$key] = [
                        'product_id' => $product_id,
                        'option_id' => $option[$key],
                        'option_value_id' => $opValue[$key],
                        'quantity' => $qty[$key],
                        'subtract' => ($subtract[$key] == 'plus') ? null : 1,
                        'price' => $price_op[$key],
                    ];
                }
                $optionTable = DB()->table('cc_product_option');
                $optionTable->insertBatch($optionData);
            }
            //product options table data insert(end)


            //product Attribute table data insert(start)
            $attribute_group_id = $this->request->getPost('attribute_group_id[]');
            $name = $this->request->getPost('name[]');
            $details = $this->request->getPost('details[]');

            $attributeTableDel = DB()->table('cc_product_attribute');
            $attributeTableDel->where('product_id', $product_id)->delete();

            if (!empty($attribute_group_id)) {
                $attributeData = [];
                foreach ($attribute_group_id as $key => $val) {
                    $attributeData[$key] = [
                        'product_id' => $product_id,
                        'attribute_group_id' => $attribute_group_id[$key],
                        'name' => $name[$key],
                        'details' => $details[$key],
                    ];
                }
                $attributeTable = DB()->table('cc_product_attribute');
                $attributeTable->insertBatch($attributeData);
            }

            //product Attribute table data insert(end)


            //product product_special table data insert(start)
            $special_price = $this->request->getPost('special_price');
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');

            if (!empty($special_price)) {
                $specialData['product_id'] = $product_id;
                $specialData['special_price'] = $special_price;
                $specialData['start_date'] = $start_date;
                $specialData['end_date'] = $end_date;

                $specialTable = DB()->table('cc_product_special');
                $checkSpec = $specialTable->where('product_id', $product_id)->countAllResults();
                if (empty($checkSpec)) {
                    $specialTable->insert($specialData);
                } else {
                    $specialTable->where('product_id', $product_id)->update($specialData);
                }
            } else {
                $specialTable = DB()->table('cc_product_special');
                $specialTable->where('product_id', $product_id)->delete();
            }
            //product product_special table data insert(end)


            //product_related table data insert(start)
            $product_related = $this->request->getPost('product_related[]');

            $proReltableDel = DB()->table('cc_product_related');
            $proReltableDel->where('product_id', $product_id)->delete();

            if (!empty($product_related)) {
                $proRelData = [];
                foreach ($product_related as $key => $relp) {
                    $proRelData[$key] = [
                        'product_id' => $product_id,
                        'related_id' => $relp,
                    ];
                }
                $proReltable = DB()->table('cc_product_related');
                $proReltable->insertBatch($proRelData);
            }
            //product_related table data insert(end)


            // product_bought_together table data insert(start)
            $bought_together = $this->request->getPost('bought_together[]');

            $boughtTogetherDel = DB()->table('cc_product_bought_together');
            $boughtTogetherDel->where('product_id', $product_id)->delete();

            if (!empty($bought_together)) {

                $proBothData = [];
                foreach ($bought_together as $key => $bothp) {
                    $proBothData[$key] = [
                        'product_id' => $product_id,
                        'related_id' => $bothp,
                    ];
                }
                $proBothtable = DB()->table('cc_product_bought_together');
                $proBothtable->insertBatch($proBothData);
            }
            //product_bought_together table data insert(end)


            DB()->transComplete();
            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Products Update Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('product_update/' . $product_id);
        }
    }

    /**
     * @description This method provides product delete
     * @return ResponseInterface
     */
    public function delete()
    {
        $product_id = $this->request->getPost('product_id');

        helper('filesystem');

        DB()->transStart();

        $target_dir = FCPATH . '/uploads/products/' . $product_id;
        if (file_exists($target_dir)) {
            delete_files($target_dir, TRUE);
            rmdir($target_dir);
        }

        $targetDirCash = FCPATH . '/cache/uploads/products/' . $product_id;
        if (file_exists($targetDirCash)) {
            delete_files($targetDirCash, TRUE);
            rmdir($targetDirCash);
        }

        $proTable = DB()->table('cc_products');
        $proTable->where('product_id', $product_id)->delete();

        $proImgTable = DB()->table('cc_product_image');
        $proImgTable->where('product_id', $product_id)->delete();

        $catTableDel = DB()->table('cc_product_to_category');
        $catTableDel->where('product_id', $product_id)->delete();

        $proFreetable = DB()->table('cc_product_free_delivery');
        $proFreetable->where('product_id', $product_id)->delete();

        $proDescTable = DB()->table('cc_product_description');
        $proDescTable->where('product_id', $product_id)->delete();

        $optionTableDel = DB()->table('cc_product_option');
        $optionTableDel->where('product_id', $product_id)->delete();

        $attributeTableDel = DB()->table('cc_product_attribute');
        $attributeTableDel->where('product_id', $product_id)->delete();

        $specialTable = DB()->table('cc_product_special');
        $specialTable->where('product_id', $product_id)->delete();

        $proReltableDel = DB()->table('cc_product_related');
        $proReltableDel->where('product_id', $product_id)->delete();

        $relProTableDel = DB()->table('cc_product_related');
        $relProTableDel->where('related_id', $product_id)->delete();

        $proBotTableDel = DB()->table('cc_product_bought_together');
        $proBotTableDel->where('product_id', $product_id)->delete();

        $bothTableDel = DB()->table('cc_product_bought_together');
        $bothTableDel->where('related_id', $product_id)->delete();

        DB()->transComplete();

        $message = '<div class="alert alert-success alert-dismissible" role="alert">Products Delete Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

        return $this->response
            ->setHeader('X-CSRF-TOKEN', csrf_hash())
            ->setBody($message);
    }

    /**
     * @description This method provides get subCategory
     * @return void
     */
    public function get_subCategory()
    {
        $categoryID = $this->request->getPost('cat_id');
        $table = DB()->table('cc_product_category');
        $data = $table->where('parent_id', $categoryID)->get()->getResult();
        $view = '';
        if (!empty($data)) {
            $view .= '<label>Sub Category</label><select name="sub_category" class="form-control" ><option value="">Please select</option>';
            foreach ($data as $val) {
                $view .= '<option value="' . $val->prod_cat_id . '" >' . $val->category_name . '</option>';
            }
            $view .= '</select>';
        }

        print $view;
    }

    /**
     * @description This method provides related product
     * @return ResponseInterface
     */
    public function related_product()
    {
        $product = [];
        $keyword = $this->request->getGet('q');
        $table = DB()->table('cc_products');
        $product = $table->like('name', $keyword)->get()->getResult();

        return $this->response->setJSON($product);
    }

    /**
     * @description This method provides image delete
     * @return ResponseInterface
     */
    public function image_delete()
    {
        helper('filesystem');

        $product_image_id = $this->request->getPost('product_image_id');
        $table = DB()->table('cc_product_image');
        $data = $table->where('product_image_id', $product_image_id)->get()->getRow();

        $targetDir = FCPATH . '/uploads/products/' . $data->product_id . '/' . $product_image_id;
        if (file_exists($targetDir)) {
            delete_files($targetDir, TRUE);
            rmdir($targetDir);
        }

        $targetDirCache = FCPATH . '/cache/uploads/products/' . $data->product_id . '/' . $product_image_id;
        if (file_exists($targetDirCache)) {
            delete_files($targetDirCache, TRUE);
            rmdir($targetDirCache);
        }

        $table->where('product_image_id', $product_image_id)->delete();
        $message = '<div class="alert alert-success alert-dismissible" role="alert">Image Delete Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        return $this->response
            ->setHeader('X-CSRF-TOKEN', csrf_hash())
            ->setBody($message);
    }

    /**
     * @description This method provides product option search
     * @return ResponseInterface
     */
    public function product_option_search()
    {
        $keyword = $this->request->getPost('key');
        $table = DB()->table('cc_option');
        $option = $table->like('name', $keyword)->get()->getResult();

        $view = '<ul class="list-unstyled list-op-aj" >';
        foreach ($option as $op) {
            $optionname = "'$op->name'";
            $optionname2 = "'" . strtolower(str_replace(' ', '', $op->name)) . "'";
            $view .= '<li><a href="javascript:void(0)" onclick="optionViewPro(' . $op->option_id . ',' . $optionname2 . ',' . $optionname . ')" >' . $op->name . '</a></li>';
        }
        $view .= '</ul>';

        return $this->response
            ->setHeader('X-CSRF-TOKEN', csrf_hash())
            ->setBody($view);
    }

    /**
     * @description This method provides product option value search
     * @return ResponseInterface
     */
    public function product_option_value_search()
    {
        $option_id = $this->request->getPost('option_id');
        $table = DB()->table('cc_option_value');
        $data = $table->where('option_id', $option_id)->get()->getResult();
        $view = '';
        foreach ($data as $item) {
            $view .= '<option value="' . $item->option_value_id . '">' . $item->name . '</option>';
        }

        return $this->response
            ->setHeader('X-CSRF-TOKEN', csrf_hash())
            ->setBody($view);
    }

    /**
     * @description This method provides product image crop
     * @return RedirectResponse|void
     */
    public function image_crop()
    {
        $allProductId = $this->request->getPost('productId[]');

        if (!empty($allProductId)) {
            $modules = modules_access();

            //old image query
            $oldProArr = $this->old_image($allProductId);

            //multi image
            $allImage = $this->multi_image($allProductId);


            foreach ($allProductId as $k => $productId) {
                $single = $oldProArr[$k];

                //product main image crop
                $target_dir = FCPATH . '/uploads/products/' . $single->product_id . '/';
                if ((!empty($single->image)) && (file_exists($target_dir))) {
                    $mainImg = str_replace('pro_', '', $single->image);
                    if (file_exists($target_dir . '/' . $mainImg)) {

                        $this->imageProcessing->image_crop($target_dir, $mainImg, $single->image);
                        if ($modules['watermark'] == '1') {
                            $this->imageProcessing->watermark_main_image($target_dir, $mainImg);

                            $this->imageProcessing->watermark_on_resized_image($target_dir, $mainImg);
                            $this->imageProcessing->image_crop($target_dir, '600_wm_' . $mainImg, 'wm_' . $single->image);
                        }
                    }
                }
                //product main image crop end


                // Disable output buffering
                if (ob_get_level() > 0) {
                    ob_end_flush();
                }
                ob_implicit_flush(true);


                // ob_start();

                echo "Starting process...<br>";
                flush(); // Send the output to the browser


                //multi image crop
                if (!empty($allImage)) {
                    $i = 0;
                    foreach ($allImage as $key => $val) {
                        if ($val->product_id == $single->product_id) {
                            $target_dir_mult = FCPATH . '/uploads/products/' . $val->product_id . '/' . $val->product_image_id . "/";
                            $oldImgMul = $val->image;
                            if ((!empty($oldImgMul)) && (file_exists($target_dir_mult))) {
                                $mainImgMul = str_replace('pro_', '', $oldImgMul);
                                if (file_exists($target_dir_mult . '/' . $mainImgMul)) {
                                    $this->imageProcessing->image_crop($target_dir_mult, $mainImgMul, $oldImgMul);
                                    if ($modules['watermark'] == '1') {
                                        $this->imageProcessing->watermark_main_image($target_dir_mult, $mainImgMul);

                                        $this->imageProcessing->watermark_on_resized_image($target_dir_mult, $mainImgMul);
                                        $this->imageProcessing->image_crop($target_dir_mult, '600_wm_' . $mainImgMul, 'wm_' . $oldImgMul);
                                    }
                                }
                            }

                            echo "Processing step " . $i++ . " ...<br>";
                            // ob_flush();
                            flush(); // Send the output to the browser
                            // sleep(1); // Simulate delay
                        }
                    }
                }
            }


            echo "Process completed!<br>";
            flush(); // Send the final output

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            $redirect_url = isset($_COOKIE['product_url_path']) ? $_COOKIE['product_url_path'] : 'products';
            echo "<script>
                    window.location.href = '" . site_url($redirect_url) . "';
              </script>";
            flush(); // Ensure the redirect script is sent

        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->back();
        }
    }

    /**
     * @description This method provides product old image
     * @param array $productarray
     * @return array
     */
    private function old_image($productarray)
    {
        $table = DB()->table('cc_products');
        $table->select('product_id, image');
        foreach ($productarray as $productId) {
            $table->orWhere('product_id', $productId);
        }
        return $table->get()->getResult();
    }

    /**
     * @description This method provides multi image
     * @param array $productarray
     * @return array
     */
    private function multi_image($productarray)
    {
        $table = DB()->table('cc_product_image');
        $table->select('product_image_id,product_id, image');
        foreach ($productarray as $productId) {
            $table->orWhere('product_id', $productId);
        }
        return $table->get()->getResult();
    }

    /**
     * @description This method provides multi delete action
     * @return RedirectResponse
     */
    public function multi_update_with_gemini()
    {
        $apiKey = get_lebel_by_value_in_settings('gemini_api_key');
        if (empty($apiKey)) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">API Key is missing <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('products');
        }

        $apiUrl = getenv('GEMINI_API_URL');
        $url = $apiUrl . "?key=" . $apiKey;

        $allProductId = $this->request->getGet('productId');
        $allImage     = $this->request->getGet('productImage');
        $allPrice     = $this->request->getGet('productPrice');
        $allQuantity  = $this->request->getGet('productQuantity');
        $allBrand     = $this->request->getGet('brand_id'); // Assuming this array holds current brand names or IDs
        $prompt       = $this->request->getGet('gemini_prompt');

        if (empty($allProductId)) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">No products selected <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('products');
        }

        // Fetch Brands for Prompt mapping
        $tableBrand = DB()->table('cc_brand');
        $brands = $tableBrand->where('status', 'Active')->orderBy('name', 'ASC')->get()->getResult();
        $availableBrands = array_column($brands, 'brand_id', 'name'); // Map Name => ID for the AI to understand
        $availableBrandsJson = json_encode($availableBrands, JSON_PRETTY_PRINT);

        // Build metadata array (unique_id etc.)
        $metadata = [];
        $parts    = [];

        foreach ($allProductId as $productId) {
            if (isset($allImage[$productId])) {
                $currentBrandName = !empty($allBrand[$productId]) ? $allBrand[$productId] : 'N/A';

                $metadata[] = [
                    'unique_id'          => (string)$productId,
                    'image'              => $allImage[$productId],
                    'current_price'      => $allPrice[$productId],
                    'quantity'           => $allQuantity[$productId],
                    'current_brand_name' => (string)$currentBrandName
                ];

                $image_path = get_product_original_image_path('uploads/products', $productId, $allImage[$productId]);

                if (is_file($image_path)) {
                    $parts[] = [
                        "inline_data" => [
                            "mime_type" => mime_content_type($image_path),
                            "data"      => base64_encode(file_get_contents($image_path))
                        ]
                    ];
                }
            }
        }

        if (empty($parts)) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">No valid images found <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('products');
        }

        // Fetch Categories
        $table = DB()->table('cc_product_category');
        $categories = $table->where('status', '1')->get()->getResultArray();
        $availableCategories = array_column($categories, 'prod_cat_id', 'category_name');
        $availableCategoriesJson = json_encode($availableCategories, JSON_PRETTY_PRINT);

        $parts = array_merge([["text" => $this->getBatchPromptUpdate($availableCategoriesJson, $availableBrandsJson, $prompt ?? null, $metadata)]], $parts);

        // Payload schema
        $payload = [
            "contents" => [["parts" => $parts]],
            "generationConfig" => [
                "temperature" => 0.4,
                "response_mime_type" => "application/json",
                "response_schema" => [
                    "type" => "OBJECT",
                    "properties" => [
                        "products" => [
                            "type" => "ARRAY",
                            "items" => [
                                "type" => "OBJECT",
                                "properties" => [
                                    "unique_id"          => ["type" => "STRING"],
                                    "image"              => ["type" => "STRING"],
                                    "name"               => ["type" => "STRING"],
                                    "alt_name"           => ["type" => "STRING"],
                                    "description"        => ["type" => "STRING", "format" => "html"],
                                    "current_price"      => ["type" => "NUMBER"],
                                    "price"              => ["type" => "NUMBER"],
                                    "weight"             => ["type" => "STRING"],
                                    "model"              => ["type" => "STRING"],
                                    "tags"               => ["type" => "STRING"],
                                    "meta_title"         => ["type" => "STRING"],
                                    "meta_description"   => ["type" => "STRING"],
                                    "meta_keyword"       => ["type" => "STRING"],
                                    "current_brand_name" => ["type" => "STRING"], // Fixed typo here
                                    "brand_id"           => ["type" => "INTEGER"],
                                    "category_ids"       => ["type" => "ARRAY", "items" => ["type" => "INTEGER"]]
                                ],
                                "required" => [
                                    "unique_id",
                                    "image",
                                    "name",
                                    "alt_name",
                                    "description",
                                    "current_price",
                                    "price",
                                    "weight",
                                    "model",
                                    "tags",
                                    "meta_title",
                                    "meta_description",
                                    "meta_keyword",
                                    "current_brand_name", // Fixed typo here
                                    "brand_id",
                                    "category_ids"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $client = \Config\Services::curlrequest();

        // API Retry Backoff logic
        $maxRetries = 3;
        $retryDelay = 3;
        $result = null;

        try {
            for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
                // Added 'http_errors' => false to prevent CI4 from throwing exception on 429
                $response = $client->setBody(json_encode($payload))
                    ->setHeader('Content-Type', 'application/json')
                    ->request('POST', $url, [
                        'timeout' => 2000,
                        'http_errors' => false
                    ]);

                $statusCode = $response->getStatusCode();
                $result = json_decode($response->getBody(), true);

                // Handle Rate Limits (429) gracefully
                if ($statusCode === 429) {
                    if ($attempt === $maxRetries) {
                        throw new \Exception('Gemini API Rate Limit exceeded after multiple retries. Try a smaller batch.');
                    }
                    sleep($retryDelay);
                    $retryDelay *= 2; // 3s, then 6s delay
                    continue;
                }

                // Handle generic API Errors
                if ($statusCode >= 400 || isset($result['error'])) {
                    $errorMessage = $result['error']['message'] ?? "HTTP Error $statusCode";
                    throw new \Exception('Gemini API Error: ' . $errorMessage);
                }

                // Success, break the retry loop
                break;
            }

            $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if (!$responseText) {
                throw new \Exception('Empty response from AI.');
            }

            $decoded = json_decode($responseText, true);
            if (json_last_error() !== JSON_ERROR_NONE || !isset($decoded['products'])) {
                throw new \Exception('Invalid AI JSON structure returned.');
            }

            // Re-order based on metadata unique_id
            $productMap = array_column($decoded['products'], null, 'unique_id');

            $orderedProducts = [];
            foreach ($metadata as $meta) {
                $orderedProducts[] = $productMap[$meta['unique_id']] ?? $this->getErrorProduct($meta);
            }

            echo view(
                'Admin/Products/update-gemini',
                [
                    'products'   => $orderedProducts,
                    'categories' => $categories,
                    'csrfHash'   => csrf_hash(),
                    'brands'     => $brands,
                ]
            );
        } catch (\Exception $e) {
            $this->session->setFlashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible" role="alert">API Update failed: ' . $e->getMessage() . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            );
            return redirect()->to('products');
        }
    }

    public function product_gemini_update_action()
    {
        // Restrict access strictly to AJAX POST interactions
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'status'  => 'error',
                'message' => 'Direct script access is not allowed.'
            ]);
        }

        $adUserId   = $this->session->adUserId;
        $product_id = $this->request->getPost('product_id');

        if (empty($product_id)) {
            return $this->response->setJSON([
                'status'    => 'error',
                'message'   => 'Missing target Product Identifier.',
                'csrf_hash' => csrf_hash()
            ]);
        }

        // Capture direct keys (no longer nested inside batch loops)
        $data = [
            'pro_name'          => $this->request->getPost('name') ?? '',
            'alt_name'          => $this->request->getPost('alt_name') ?? '',
            'model'             => $this->request->getPost('model') ?? '',
            'categorys'         => $this->request->getPost('categorys') ?? [],
            'description'       => $this->request->getPost('description') ?? '',
            'price'             => $this->request->getPost('price') ?? '',
            'quantity'          => $this->request->getPost('quantity') ?? '',
            'brand_id'          => $this->request->getPost('brand_id') ?? '',
            'weight'            => $this->request->getPost('weight') ?? null,
            'tag'               => $this->request->getPost('tags') ?? null,
            'meta_title'        => $this->request->getPost('meta_title') ?? null,
            'meta_description'  => $this->request->getPost('meta_description') ?? null,
            'meta_keyword'      => $this->request->getPost('meta_keyword') ?? null,
        ];

        // Validation setup using the incoming flat data signature
        $this->validation->setRules([
            'pro_name'    => ['label' => 'Name', 'rules' => 'required'],
            'alt_name'    => ['label' => 'Alt Name', 'rules' => 'required'],
            'categorys'   => ['label' => 'Category', 'rules' => 'required'],
            'description' => ['label' => 'Description', 'rules' => 'required'],
            'price'       => ['label' => 'Price', 'rules' => 'required|numeric'],
            'quantity'    => ['label' => 'Quantity', 'rules' => 'required|is_natural_no_zero'],
        ]);

        if ($this->validation->run($data) === false) {
            return $this->response->setJSON([
                'status'    => 'validation_error',
                'message'   => $this->validation->listErrors(),
                'csrf_hash' => csrf_hash() // Always return hash to avoid mismatching subsequent requests
            ]);
        }

        // Begin Database transaction block
        DB()->transStart();

        // 1. Update Core Product attributes
        $proData = [
            'name'      => $data['pro_name'],
            'alt_name'  => $data['alt_name'],
            'model'     => $data['model'],
            'price'     => $data['price'],
            'brand_id'  => $data['brand_id'],
            'weight'    => $data['weight'],
            'quantity'  => $data['quantity'],
            'updatedBy' => $adUserId,
        ];
        DB()->table('cc_products')->where('product_id', $product_id)->update($proData);

        // 2. Refresh Category relationships
        DB()->table('cc_product_to_category')->where('product_id', $product_id)->delete();
        if (!empty($data['categorys'])) {
            $catData = array_map(fn($catId) => [
                'product_id'  => $product_id,
                'category_id' => $catId,
            ], $data['categorys']);
            DB()->table('cc_product_to_category')->insertBatch($catData);
        }

        // 3. Update Text Content Descriptions and Meta Tags
        $proDescData = [
            'description'      => $data['description'],
            'tag'              => $data['tag'],
            'meta_title'       => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'meta_keyword'     => $data['meta_keyword'],
        ];
        DB()->table('cc_product_description')->where('product_id', $product_id)->update($proDescData);

        // Complete Transaction
        DB()->transComplete();

        if (DB()->transStatus() === false) {
            DB()->transRollback();
            return $this->response->setJSON([
                'status'    => 'error',
                'message'   => 'Database execution breakdown. Changes rolled back.',
                'csrf_hash' => csrf_hash()
            ]);
        }

        // Return successful async response state
        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => '<strong>' . esc($data['pro_name']) . '</strong> updated successfully.',
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function product_gemini_update_batch_action()
    {
        // Restrict access strictly to AJAX POST interactions
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'status'  => 'error',
                'message' => 'Direct script access is not allowed.'
            ]);
        }

        $adUserId = $this->session->adUserId;
        $products = $this->request->getPost('products');

        if (empty($products) || !is_array($products)) {
            return $this->response->setJSON([
                'status'    => 'error',
                'message'   => 'No valid product batch data received.',
                'csrf_hash' => csrf_hash()
            ]);
        }

        // 1. First-pass Validation: Validate ALL items before running any SQL queries
        foreach ($products as $index => $p) {
            $displayIndex = $index + 1;

            // Structure data matching your exact original key validation expectations
            $validationData = [
                'pro_name'    => $p['name'] ?? '',
                'alt_name'    => $p['alt_name'] ?? '',
                'categorys'   => $p['categorys'] ?? [],
                'description' => $p['description'] ?? '',
                'brand_id'    => $p['brand_id'] ?? '',
                'price'       => $p['price'] ?? '',
                'quantity'    => $p['quantity'] ?? '',
            ];

            $this->validation->setRules([
                'pro_name'    => ['label' => "Product #{$displayIndex} Name", 'rules' => 'required'],
                'alt_name'    => ['label' => "Product #{$displayIndex} Alt Name", 'rules' => 'required'],
                'categorys'   => ['label' => "Product #{$displayIndex} Category", 'rules' => 'required'],
                'description' => ['label' => "Product #{$displayIndex} Description", 'rules' => 'required'],
                'price'       => ['label' => "Product #{$displayIndex} Price", 'rules' => 'required|numeric'],
                'quantity'    => ['label' => "Product #{$displayIndex} Quantity", 'rules' => 'required|is_natural_no_zero'],
                'brand_id'    => ['label' => "Product #{$displayIndex} Brand", 'rules' => 'required'],
            ]);

            if ($this->validation->run($validationData) === false) {
                return $this->response->setJSON([
                    'status'    => 'validation_error',
                    'message'   => $this->validation->listErrors(),
                    'csrf_hash' => csrf_hash()
                ]);
            }

            // Double check identifier presence
            if (empty($p['product_id'])) {
                return $this->response->setJSON([
                    'status'    => 'error',
                    'message'   => "Missing target Product Identifier at position #{$displayIndex}.",
                    'csrf_hash' => csrf_hash()
                ]);
            }
        }

        // 2. Database transaction processing block
        DB()->transStart();

        try {
            foreach ($products as $p) {
                $productId = $p['product_id'];

                // Map standard keys precisely like your original single action
                $proName     = $p['name'] ?? '';
                $altName     = $p['alt_name'] ?? '';
                $model       = $p['model'] ?? '';
                $categories  = $p['categorys'] ?? [];
                $description = $p['description'] ?? '';
                $brandId     = $p['brand_id'] ?? '';
                $price       = $p['price'] ?? '';
                $quantity    = $p['quantity'] ?? '';
                $weight      = !empty($p['weight']) ? $p['weight'] : null;
                $tag         = !empty($p['tags']) ? $p['tags'] : null;
                $metaTitle   = !empty($p['meta_title']) ? $p['meta_title'] : null;
                $metaDesc    = !empty($p['meta_description']) ? $p['meta_description'] : null;
                $metaKeyword = !empty($p['meta_keyword']) ? $p['meta_keyword'] : null;

                // Update Table: cc_products
                $proData = [
                    'name'      => $proName,
                    'alt_name'  => $altName,
                    'model'     => $model,
                    'price'     => $price,
                    'weight'    => $weight,
                    'quantity'  => $quantity,
                    'brand_id'  => $brandId,
                    'updatedBy' => $adUserId,
                ];
                DB()->table('cc_products')->where('product_id', $productId)->update($proData);

                // Update Table: cc_product_to_category
                DB()->table('cc_product_to_category')->where('product_id', $productId)->delete();
                if (!empty($categories)) {
                    $catData = array_map(fn($catId) => [
                        'product_id'  => $productId,
                        'category_id' => $catId,
                    ], $categories);
                    DB()->table('cc_product_to_category')->insertBatch($catData);
                }

                // Update Table: cc_product_description
                $proDescData = [
                    'description'      => $description,
                    'tag'              => $tag,
                    'meta_title'       => $metaTitle,
                    'meta_description' => $metaDesc,
                    'meta_keyword'     => $metaKeyword,
                ];
                DB()->table('cc_product_description')->where('product_id', $productId)->update($proDescData);
            }

            // Complete Transaction execution
            DB()->transComplete();

            if (DB()->transStatus() === false) {
                DB()->transRollback();
                return $this->response->setJSON([
                    'status'    => 'error',
                    'message'   => 'Database execution breakdown during batch processing. All changes rolled back.',
                    'csrf_hash' => csrf_hash()
                ]);
            }

            return $this->response->setJSON([
                'status'    => 'success',
                'message'   => 'Successfully batch updated <strong>' . count($products) . '</strong> products.',
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            DB()->transRollback();
            return $this->response->setJSON([
                'status'    => 'error',
                'message'   => 'Critical application failure: ' . $e->getMessage(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }
    public function multi_delete_action()
    {
        $allProductId = $this->request->getPost('productId[]');
        if (!empty($allProductId)) {
            helper('filesystem');

            DB()->transStart();
            foreach ($allProductId as $product_id) {


                $targetDir = FCPATH . '/uploads/products/' . $product_id;
                if (file_exists($targetDir)) {
                    delete_files($targetDir, TRUE);
                    rmdir($targetDir);
                }
                //cache delete
                $targetDirCache = FCPATH . '/cache/uploads/products/' . $product_id;
                if (file_exists($targetDirCache)) {
                    delete_files($targetDirCache, TRUE);
                    rmdir($targetDirCache);
                }

                $proTable = DB()->table('cc_products');
                $proTable->where('product_id', $product_id)->delete();

                $proImgTable = DB()->table('cc_product_image');
                $proImgTable->where('product_id', $product_id)->delete();

                $catTableDel = DB()->table('cc_product_to_category');
                $catTableDel->where('product_id', $product_id)->delete();

                $proFreetable = DB()->table('cc_product_free_delivery');
                $proFreetable->where('product_id', $product_id)->delete();

                $proDescTable = DB()->table('cc_product_description');
                $proDescTable->where('product_id', $product_id)->delete();

                $optionTableDel = DB()->table('cc_product_option');
                $optionTableDel->where('product_id', $product_id)->delete();

                $attributeTableDel = DB()->table('cc_product_attribute');
                $attributeTableDel->where('product_id', $product_id)->delete();

                $specialTable = DB()->table('cc_product_special');
                $specialTable->where('product_id', $product_id)->delete();

                $proReltableDel = DB()->table('cc_product_related');
                $proReltableDel->where('product_id', $product_id)->delete();

                $relProTableDel = DB()->table('cc_product_related');
                $relProTableDel->where('related_id', $product_id)->delete();

                $proBotTableDel = DB()->table('cc_product_bought_together');
                $proBotTableDel->where('product_id', $product_id)->delete();

                $bothTableDel = DB()->table('cc_product_bought_together');
                $bothTableDel->where('related_id', $product_id)->delete();
            }
            DB()->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Products Delete Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            //            return redirect()->to('products');
            return redirect()->back();
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            //            return redirect()->to('products');
            return redirect()->back();
        }
    }

    /**
     * @description This method provides product image sort action
     * @return ResponseInterface
     */
    public function product_image_sort_action()
    {
        $product_image_id = $this->request->getPost('product_image_id');

        $data['sort_order'] = $this->request->getPost('value');
        $table = DB()->table('cc_product_image');
        $table->where('product_image_id', $product_image_id)->update($data);
        return $this->response
            ->setHeader('X-CSRF-TOKEN', csrf_hash());
    }

    /**
     * @description This method provides product image alt name action
     * @return ResponseInterface
     */
    public function productImageAltNameAction()
    {
        $product_image_id = $this->request->getPost('product_image_id');

        $data['alt_name'] = $this->request->getPost('value');
        $table = DB()->table('cc_product_image');
        $table->where('product_image_id', $product_image_id)->update($data);
        return $this->response
            ->setHeader('X-CSRF-TOKEN', csrf_hash());
    }

    /**
     * @description This method provides product index page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {
            $uri = service('uri');
            $urlString = $uri->getPath() . '?' . $this->request->getServer('QUERY_STRING');
            setcookie('product_url_path', $urlString, time() + 86400, "/");

            $length = $this->request->getGet('length');
            $keyWord = $this->request->getGet('keyWord');
            $pageNum = $this->request->getGet('page');

            $perPage = !empty($length) ? $length : 10;
            if (empty($keyWord)) {
                $data['product'] = $this->productsModel->orderBy('product_id', 'desc')->paginate($perPage);
            } else {
                $data['product'] = $this->productsModel->search_data($keyWord)->orderBy('product_id', 'desc')->paginate($perPage);
            }


            $data['pager'] = $this->productsModel->pager;
            $data['links'] = $data['pager']->links('default', 'custom_pagination');


            $data['keyWord'] = $keyWord;
            $data['length'] = $length;

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Products/list', $data);
            } else {
                echo view('Admin/no_permission');
            }

            if (isset(newSession()->resetDatatable)) {
                unset($_SESSION['resetDatatable']);
            }
        }
    }

    /**
     * @description This method provides product list view
     * @return void
     */
    public function products_list()
    {

        $theme = get_lebel_by_value_in_settings('Theme');
        if ($theme == 'Theme_3') {
            $theme_libraries = $this->theme_3;
        }
        if ($theme == 'Default') {
            $theme_libraries = $this->theme_default;
        }
        if ($theme == 'Theme_2') {
            $theme_libraries = $this->theme_2;
        }

        //        print 'ok w.png';
        $target_dir = FCPATH . '/uploads/';

        //        $this->crop->withFile($target_dir . 'img.jpg')->fit('600', '600', 'center')->save($target_dir . 'new_crop2.jpg','100');
        $bg = imagecreatefromjpeg($target_dir . 'new_crop2.jpg');
        $wm = imagecreatefrompng($target_dir . 'wt.png');

        //        $wm_size = getimagesize($target_dir.'wt.png');
        //        imagecopy($bg, $wm, 160, 320, 0, 0, $wm_size[0], $wm_size[1]);
        //        imagecopy($bg, $wm, 160, 320, 0, 0, $wm_size[0], $wm_size[1]);


        $marge_right = 50;
        $marge_bottom = 60;
        $sx = imagesx($wm);
        $sy = imagesy($wm);
        //
        imagecopy($bg, $wm, imagesx($bg) - $sx - $marge_right, imagesy($bg) - $sy - $marge_bottom, 0, 0, imagesx($wm), imagesy($wm));

        //        $w = 200;
        //        $h = $w * $size[1] / $size[0];

        //        $imf = imagecreatetruecolor($w, $h);
        //        imagecopyresampled($bg, $wm, 230, 330,0,0, $w,$h,$size[0],$size[1]);

        ob_start();
        imagejpeg($bg, null, 100);
        $data = ob_get_clean();

        echo '<img src="data:image/jpeg;base64,' . base64_encode($data) . '" />';
        //        imagePng($bg, $target_dir.'image4.jpg');
        //
        //        foreach ($theme_libraries->product_image as $pro_img) {
        //                $this->crop->withFile($target_dir . 'image4.jpg')->fit($pro_img['width'], $pro_img['height'], 'center')->save($target_dir . $pro_img['width'] . 'image4.jpg','100');
        //
        //        }


    }

    /**
     * @description This method provides status update
     * @return RedirectResponse|void
     */
    public function status_update()
    {

        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {
            $redirect_url = isset($_COOKIE['product_url_path']) ? $_COOKIE['product_url_path'] : 'admin/products';

            $allProductId = $this->request->getPost('productId[]');
            if (!empty($allProductId)) {

                $data['all_product'] = $allProductId;

                //$perm = array('create','read','update','delete','mod_access');
                $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
                foreach ($perm as $key => $val) {
                    $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
                }
                if (isset($data['update']) and $data['update'] == 1) {
                    echo view('Admin/Products/status_update', $data);
                } else {
                    echo view('Admin/no_permission');
                }
            } else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect()->to($redirect_url);
            }
        }
    }

    /**
     * @description This method provides status update action
     * @return RedirectResponse
     */
    public function status_update_action()
    {
        $redirect_url = isset($_COOKIE['product_url_path']) ? $_COOKIE['product_url_path'] : 'admin/products';
        $all_product = $this->request->getPost('productId[]');
        $status = $this->request->getPost('status');

        $data['status'] = $status;

        foreach ($all_product as $product_id) {
            $table = DB()->table('cc_products');
            $table->where('product_id', $product_id);
            $table->update($data);
        }

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Product status update successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to($redirect_url);
    }

    /**
     * @description This method provides remove Cropped Images Action
     * @return RedirectResponse
     */
    public function removeCroppedImagesAction()
    {
        $redirect_url = isset($_COOKIE['product_url_path']) ? $_COOKIE['product_url_path'] : 'admin/products';
        $allProductId = $this->request->getPost('productId[]');
        if (!empty($allProductId)) {
            DB()->transStart();
            foreach ($allProductId as $product_id) {
                // Main product image
                $mainImage = get_data_by_id('image', 'cc_products', 'product_id', $product_id);

                if (!empty($mainImage)) {
                    foreach ($this->productImageSizes as $size) {
                        $basePath = FCPATH . 'uploads/products/' . $product_id . '/';
                        $resizedImage = $basePath . $size['width'] . '_' . $mainImage;
                        $resizedWatermarked = $basePath . $size['width'] . '_wm_' . $mainImage;

                        $this->imageProcessing->resize_image_unlink($resizedImage);
                        $this->imageProcessing->resize_image_unlink($resizedWatermarked);
                    }
                }

                // Multiple product images
                $images = DB()->table('cc_product_image')->where('product_id', $product_id)->get()->getResult();

                foreach ($images as $img) {
                    foreach ($this->productImageSizes as $size) {
                        $multiPath = FCPATH . 'uploads/products/' . $product_id . '/' . $img->product_image_id . '/';
                        $resizedImage = $multiPath . $size['width'] . '_' . $img->image;
                        $resizedWatermarked = $multiPath . $size['width'] . '_wm_' . $img->image;

                        $this->imageProcessing->resize_image_unlink($resizedImage);
                        $this->imageProcessing->resize_image_unlink($resizedWatermarked);
                    }
                }
            }
            DB()->transComplete();
            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Image remove successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select at least one product<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        return redirect()->to($redirect_url);
    }
    
    /**
     * @description This method provides remove Watermark Images Action
     * @return RedirectResponse
     */
    public function removeWatermarkImagesAction()
    {
        $redirect_url = isset($_COOKIE['product_url_path']) ? $_COOKIE['product_url_path'] : 'admin/products';
        $allProductId = $this->request->getPost('productId[]');
        if (!empty($allProductId)) {
            DB()->transStart();
            foreach ($allProductId as $product_id) {
                // Main product image
                $mainImage = get_data_by_id('image', 'cc_products', 'product_id', $product_id);
                $mainImageFinal = str_replace("pro_", "", $mainImage);
                if (!empty($mainImage)) {
                    $basePath = FCPATH . 'uploads/products/' . $product_id . '/wm_' . $mainImageFinal;
                    $this->imageProcessing->image_unlink($basePath);
                }

                // Multiple product images
                $images = DB()->table('cc_product_image')->where('product_id', $product_id)->get()->getResult();
                foreach ($images as $img) {
                    $imageFinal = str_replace("pro_", "", $img->image);
                    $multiPath = FCPATH . 'uploads/products/' . $product_id . '/' . $img->product_image_id . '/wm_' . $imageFinal;
                    $this->imageProcessing->image_unlink($multiPath);
                }
            }
            DB()->transComplete();
            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Image remove successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select at least one product<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        return redirect()->to($redirect_url);
    }
}
