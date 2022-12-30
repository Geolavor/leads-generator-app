<?php

namespace LeadBrowser\UI\DataGrid\Traits;

trait ProvideExport
{
    /**
     * Export data.
     *
     * @return object
     */
    public function export()
    {
        if ($this->export) {
            $this->init();

            $this->addColumns();

            $this->prepareTabFilters();

            $this->prepareActions();

            $this->prepareMassActions();

            $this->prepareQueryBuilder();

            $this->getCollection();

            $this->transformColumnsForExport();

            // TODO
            // $user = auth()->guard('user')->user();
            // return $this->collection->where('user_id', $user->id);
            return $this->collection;
        }

        return [];
    }

    /**
     * Finalyzation for export columns.
     *
     * @return void
     */
    protected function transformColumnsForExport()
    {
        $this->collection->transform(function ($record) {
            $this->transformColumns($record);

            return $record;
        });
    }
}
