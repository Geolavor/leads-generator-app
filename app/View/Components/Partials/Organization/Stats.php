<?php

namespace App\View\Components\partials\Organization;

use Illuminate\View\Component;

class Stats extends Component
{
    /**
     * The count employees.
     *
     * @var string
     */
    public $count_employees;

    /**
     * The count emails.
     *
     * @var string
     */
    public $count_emails;

    /**
     * The count taxs.
     *
     * @var string
     */
    public $count_taxs;

    /**
     * The risk value.
     */
    public $risk_value;

    /**
     * Create a new component instance.
     * 
     * @param string $count_employees
     * @param string $count_emails
     * @param string $count_taxs
     * @param $risk_value
     * 
     * @return void
     */
    public function __construct(string $count_employees, string $count_emails, string $count_taxs, $risk_value)
    {
        $this->count_employees = $count_employees;
        $this->count_emails = $count_emails;
        $this->count_taxs = $count_taxs;
        $this->risk_value = $risk_value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.partials.organization.stats');
    }
}
