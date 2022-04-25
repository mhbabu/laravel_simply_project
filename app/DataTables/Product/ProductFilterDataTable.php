<?php

namespace App\DataTables\Product;

use App\Modules\Product\Models\Product;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Utilities\Request;


class ProductFilterDataTable extends DataTable
{

    protected $title;
    protected $category_id;
    protected $subcategory_id;
    protected $price;

    public function __construct(Request $request)
    {
        $this->title = $request->get('title');
        $this->category_id = $request->get('category_id');
        $this->subcategory_id = $request->get('subcategory_id');
        $this->price = $request->get('price');
    }

    /**
     * Display ajax response.
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('status', function ($data) {
                return ($data->status == "Active") ? "<label class='badge badge-success'> Active </label>" : "<label class='badge badge-danger'> Inactive </label>";
            })
            ->rawColumns(['status'])
            ->make(true);

    }

    /**
     * Get query source of dataTable.
     */
    public function query()
    {
        $query = Product::leftJoin('subcategories','subcategories.id','=','products.subcategory_id')
            ->leftJoin('categories','categories.id','=','subcategories.category_id')
            ->groupBy('products.id');

        if(isset($this->title))
            $query->where('products.title', $this->title)
                ->orWhere('products.title', 'like', '%' . $this->title . '%');

        if(isset($this->price))
            $query->where('products.price', $this->price);

        if(isset($this->category_id))
            $query->where('subcategories.category_id', $this->category_id);

        if(isset($this->subcategory_id))
            $query->where('subcategories.id', $this->subcategory_id);

        $data = $query->select([
            'products.*',
            'categories.name as category_name',
            'subcategories.title as subcategory_title',
        ]);
        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters([
                'dom'         => 'Blfrtip',
                'responsive'  => true,
                'autoWidth'   => false,
                'paging'      => true,
                "pagingType"  => "full_numbers",
                'searching'   => true,
                'info'        => true,
                'searchDelay' => 350,
                "serverSide"  => true,
                'order'       => [[1, 'asc']],
                'buttons'     => ['excel','csv', 'print', 'reset', 'reload'],
                'pageLength'  => 10,
                'lengthMenu'  => [[10, 20, 25, 50, 100, 500, -1], [10, 20, 25, 50, 100, 500, 'All']],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'title'          => ['data' => 'title', 'name' => 'products.title', 'orderable' => true, 'searchable' => true],
            'category'       => ['data' => 'category_name', 'name' => 'categories.name', 'orderable' => true, 'searchable' => true],
            'subcategory'    => ['data' => 'subcategory_title', 'name' => 'subcategories.title', 'orderable' => true, 'searchable' => true],
            'price'          => ['data' => 'price', 'name' => 'products.price', 'orderable' => true, 'searchable' => true],
            'status'         => ['data' => 'status', 'name' => 'products.status', 'orderable' => true, 'searchable' => true]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'product_filter_list_' . date('Y_m_d_H_i_s');
    }
}
