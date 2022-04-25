<?php

namespace App\DataTables\Product;

use App\Modules\Product\Models\Product;
use Yajra\DataTables\Services\DataTable;

class ProductFilterDataTable extends DataTable
{

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('status', function ($data) {
                return ($data->status == "Active") ? "<label class='badge badge-success'> Active </label>" : "<label class='badge badge-danger'> Inactive </label>";
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Get query source of dataTable.
     * @return \Illuminate\Database\Eloquent\Builder
     * @internal param \App\Models\AgentBalanceTransactionHistory $model
     */
    public function query()
    {
        $query = Product::getProductList();
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
            ->setTableId('product-table')
            ->parameters([
                'dom' => 'Blfrtip',
                'responsive' => true,
                'autoWidth' => false,
                'paging' => true,
                "pagingType" => "full_numbers",
                'searching' => true,
                'info' => true,
                'searchDelay' => 350,
                "serverSide" => true,
                'order' => [[1, 'asc']],
                'buttons' => ['excel', 'csv', 'print', 'reset', 'reload'],
                'pageLength' => 10,
                'lengthMenu' => [[10, 20, 25, 50, 100, 500, -1], [10, 20, 25, 50, 100, 500, 'All']],
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
            'title'         => ['data' => 'title', 'name' => 'products.title', 'orderable' => true, 'searchable' => true],
            'category'      => ['data' => 'category_name', 'name' => 'categories.name', 'orderable' => true, 'searchable' => true],
            'subcategory'   => ['data' => 'subcategory_title', 'name' => 'subcategories.title', 'orderable' => true, 'searchable' => true],
            'price'         => ['data' => 'price', 'name' => 'products.price', 'orderable' => true, 'searchable' => true],
            'status'        => ['data' => 'status', 'name' => 'products.status', 'orderable' => true, 'searchable' => true],
            'action'        => ['searchable' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'product_list_' . date('Y_m_d_H_i_s');
    }
}
