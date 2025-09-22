<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cattegory;
use App\Models\Supplier;
use App\Models\CompanyData;
use Auth;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    
    //view all the products
    public function viewProducts()
    {
        
        //get the number of products from the database..
        $productCount = Product::all()->count();
        //get the products from the database and get the stocvk count as well
        $products = Product::leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
         ->select('products.id', 'products.name', 'products.barcode', 'products.created_at', 'products.description', 'products.price', 'products.selling_price', 'products.unit_of_measurement', DB::raw('SUM(stocks.quantity) as total_stock_quantity'))
        ->groupBy('products.id', 'products.name', 'products.barcode', 'products.description', 'products.price', 'products.selling_price', 'products.unit_of_measurement', 'products.created_at')
        ->orderByDesc('products.id') // Order by id in descending order
        ->get();
        return view('pages.view-products')->with("products",$products)->with("productCount",$productCount);
    }

    public function fetchProductsToMobile(){

        $products=Product::orderBy('id','desc')->get();
        return response()->json(['products' => $products]);
    }

    public function getPriceTags(){

        $products = DB::select("select distinct name,barcode,selling_price from products");
        return view("pages.price-tags")->with("products",$products);
    
    }

    //search by name on the cart
    public function searchByName($productName)
    {
        $products = Product::where('name', 'like', '%' . $productName . '%')->get();
        return response()->json(['products' => $products]);
    }

    //search product on the cart on grv
    public function searchProduct($productName)
    {
        $products = Product::where('name', 'like', '%' . $productName . '%')->get();
        return response()->json(['products' => $products]);
    }

    public function getProductsJson(){
       $products = DB::table('products')
        ->leftJoin('stocks', 'stocks.product_id', '=', 'products.id')
        ->select('products.id', 'products.name', 'products.price', DB::raw('SUM(stocks.quantity) as stock'))
        ->groupBy('products.id', 'products.name', 'products.price') // Include 'stock' in the GROUP BY
        ->get();
        return response()->json(["products" => $products]);
    }

    public function searchProducts($productName)
    {
        // Perform the product search based on the $productName
        $products = Product::where('name', 'like', '%' . $productName . '%')->get();
        // Return the products as JSON response
        return response()->json(["products" => $products]);
    }

    public function searchByCode($code)
    {
        // Perform the product search based on the $productName
        $products = Product::where('barcode', 'like', '%' . $code . '%')->get();
        // Return the products as JSON response
        return response()->json(["products" => $products]);
    }

    //function that will search the products    
    public function editProduct($id){ 
        $product = Product::find($id);
        $cattegories=Cattegory::orderBy("id","desc")->get();
        $suppliers = Supplier::orderBy("id","desc")->get();
        return view("pages.update-product")->with("product",$product)->with("cattegories",$cattegories)->with("suppliers",$suppliers);
    }

    
    public function getProductById($id){
        
        //get the prduct by the id
        $product = Product::find($id);
        if ($product) {
            return response()->json($product);
        }
        return response()->json(['error' => 'Product not found'], 404);
    }

    public function deleteProduct(Request $request, $id)
    {
    // Validate and sanitize the product ID
    $id = intval($id); // Ensure $id is an integer
    // Check if the product exists
    $product = Product::find($id);

    if (!$product) {
        // Product not found, return a 404 response or handle the error appropriately
        return response()->json(['error' => 'Product not found'], 404);
    }

    // Check if the user is authorized to delete the product (implement your authorization logic here)

    try {
        // Attempt to delete the product
        $product->delete();
        return redirect()->back()->with('success', 'Product Deleted Successfully');
    } catch (\Exception $e) {
        // Error occurred during deletion, handle the error gracefully
        return redirect()->back()->with('error', 'Product Not Deleted');
    }
}


    public function create()
    {
        //return the cattegories for the product to the view
        $cattegories = Cattegory::orderBy("id","desc")->get();
        $suppliers = Supplier::orderBy("id","desc")->get();
        //get the authenticated user from the database
        $user = Auth::user();
        return view("pages.add-product")->with("cattegories",$cattegories)->with("user",$user)->with("suppliers",$suppliers);
    }
    

    //qwqwqwqwqwrwrwrwrwt
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

     public function salesInvoice(){
        $companyDetails = CompanyData::latest()->first();
        return view("pages.salesInvoice")->with("details",$companyDetails);
     }

     public function store(Request $request)
     {

        $product = new Product(); 
        $product->name = $request->input("name");
        $product->barcode = $request->input("barcode");
        $product->description = $request->input("description");
        $product->price = $request->input("price");
        $product->selling_price = $request->input("selling_price");
        $product->unit_of_measurement = $request->input("unit_of_measurement");
        $product->category_id = $request->input("category_id");
        //Tax calculation remains unchanged
        $product->tax = $request->input("tax");       
        $product->save();   
         if ($product->save()) {
            return redirect()->back()->with('success', 'Product Added Successfully');
         } else {
             return redirect()->back()->with('error', 'Sorry, there was a problem while saving your product');
          }    
    }

    public function updateProduct(Request $request, Product $product)
    { 
          $product->name = $request->input("name");
          $product->barcode = $request->input("barcode");
          $product->description = $request->input("description");
          $product->price = $request->input("price");
          $product->selling_price = $request->input("selling_price");
          $product->unit_of_measurement = $request->input("unit_of_measurement");
          $product->category_id = $request->input("category_id");
          //Tax calculation remains unchanged
          $product->tax = $request->input("tax");   
               
        if ($request->has('category_id')) {
            $category = Cattegory::findOrFail($request->category_id);
            $product->category()->associate($category);
        }
        if (!$product->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'s a problem while updating the product.');
        }
        // Redirect to the 'view-products' route after successful update
        return redirect()->route('view-products')->with('success', 'Success, your product has been updated.');
    }

    //this is the function
    public function exportProducts(){

        $products = Product::all();
        // Define CSV header
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=products.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        // Generate CSV content
        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            // CSV header row
            fputcsv($file, array('Name', 'Barcode','Description','Price','Selling Price','Unit Of Measurement','Tax','Price Including Tax'));

            // CSV data rows
            foreach ($products as $product) {
                fputcsv($file, array($product->name, $product->barcode,$product->description,$product->price,$product->selling_price,$product->unit_of_measurement,$product->tax,$product->price_inc_tax));
            }
            fclose($file);
        };
        // Return CSV response
        return Response::stream($callback, 200, $headers);
    }


    public function importProducts(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240', // Max 10MB
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathName(), 'r');
        
        // Expected CSV headers
        $expectedHeaders = ['Name', 'Barcode', 'Description', 'Price', 'Selling Price', 'Unit Of Measurement', 'Tax', 'Category ID', 'Price Including Tax'];
        
        $firstRow = true;
        $rowNumber = 0;
        $errors = [];
        $successCount = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $rowNumber++;
            
            if ($firstRow) {
                // Validate CSV headers
                if (count($row) !== count($expectedHeaders)) {
                    fclose($handle);
                    return redirect()->back()->with('error', 'CSV must have exactly 9 columns: ' . implode(', ', $expectedHeaders));
                }
                $firstRow = false;
                continue;
            }

            // Validate row data
            if (count($row) !== 9) {
                $errors[] = "Row $rowNumber: Expected 9 columns, got " . count($row);
                continue;
            }

            // Validate required fields
            if (empty(trim($row[0]))) {
                $errors[] = "Row $rowNumber: Product name is required";
                continue;
            }

            if (empty(trim($row[1]))) {
                $errors[] = "Row $rowNumber: Barcode is required";
                continue;
            }

            // Validate numeric fields
            if (!is_numeric($row[3]) || $row[3] < 0) {
                $errors[] = "Row $rowNumber: Price must be a valid positive number";
                continue;
            }

            if (!is_numeric($row[4]) || $row[4] < 0) {
                $errors[] = "Row $rowNumber: Selling price must be a valid positive number";
                continue;
            }

            if (!is_numeric($row[6]) || $row[6] < 0) {
                $errors[] = "Row $rowNumber: Tax must be a valid number";
                continue;
            }

            // Validate category_id exists
            if (!empty($row[7]) && !Cattegory::find($row[7])) {
                $errors[] = "Row $rowNumber: Category ID {$row[7]} does not exist";
                continue;
            }

            // Check if barcode already exists
            if (Product::where('barcode', $row[1])->exists()) {
                $errors[] = "Row $rowNumber: Barcode {$row[1]} already exists";
                continue;
            }

            try {
                // Create product if validation passes
                $product = new Product();
                $product->name = trim($row[0]);
                $product->barcode = trim($row[1]);
                $product->description = trim($row[2]);
                $product->price = floatval($row[3]);
                $product->selling_price = floatval($row[4]);
                $product->unit_of_measurement = trim($row[5]);
                $product->tax = floatval($row[6]);
                $product->category_id = !empty($row[7]) ? intval($row[7]) : null;
                $product->price_inc_tax = trim($row[8]);
                $product->created_at = now();
                $product->updated_at = now();
                $product->save();
                
                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Row $rowNumber: Error saving product - " . $e->getMessage();
            }
        }
        
        fclose($handle);

        // Return response based on results
        if (!empty($errors)) {
            $errorMessage = "Import completed with errors. Successfully imported: $successCount products. Errors: " . implode('; ', array_slice($errors, 0, 10));
            if (count($errors) > 10) {
                $errorMessage .= ' ... and ' . (count($errors) - 10) . ' more errors.';
            }
            return redirect()->back()->with('error', $errorMessage);
        }

        return redirect()->back()->with('success', "Products imported successfully! Total imported: $successCount products.");
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}