<?php

namespace App\DataTables\Product;

use App\Modules\Product\Models\Subcategory;
use Yajra\DataTables\Services\DataTable;

class SubcategoryListDataTable extends DataTable
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
            ->addColumn('action', function ($data) {
                $actionBtn = '<a href="'. route('admin.product.subcategories.edit', $data->id) . '" class="btn btn-sm btn-primary AppModal" title="Edit" data-toggle="modal" data-target="#AppModal" title="Edit"><i class="fa fa-edit"></i> Edit</a> ';
                $actionBtn .= '<a href="' . route('admin.product.subcategories.destroy', $data->id) . '" table="subcategory-table" class="btn btn-sm btn-danger action-delete" title="Delete"><i class="fa fa-trash"></i> Delete</a> ';
                return $actionBtn;
            })
            ->addColumn('status', function ($data) {
                return ($data->status == "Active") ? "<label class='badge badge-success'> Active </label>" : "<label class='badge badge-danger'> Inactive </label>";
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    /**
     * Get query source of dataTable.
     * @return \Illuminate\Database\Eloquent\Builder
     * @internal param \App\Models\AgentBalanceTransactionHistory $model
     */
    public function query()
    {
        $query = Subcategory::getSubcategoryList();
        $data = $query->select([
            'subcategories.*',
            'categories.name as category_name'
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
            ->setTableId('subcategory-table')
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
            'title'    => ['data' => 'title', 'name' => 'subcategories.title', 'orderable' => true, 'searchable' => true],
            'category' => ['data' => 'category_name', 'name' => 'categories.name', 'orderable' => true, 'searchable' => true],
            'status'   => ['data' => 'status', 'name' => 'categories.status', 'orderable' => true, 'searchable' => true],
            'action'   => ['searchable' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(){
        return 'subcategory_list_' . date('Y_m_d_H_i_s');
    }
}
