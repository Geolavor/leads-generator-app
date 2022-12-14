<?php

namespace LeadBrowser\UI\Export;

use LeadBrowser\Organization\Models\Email;
use LeadBrowser\Organization\Models\Person;
use LeadBrowser\Result\Models\Result;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResultsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        ini_set('memory_limit', '1512M');
        ini_set('max_execution_time', '18880');
        
        return Result::query()->with([
            'organization', 'organization.taxs', 'organization.socials', 'organization.emails', 'organization.persons'
        ])->where('searchable_id', request('search_id'));
    }

    public function headings(): array
    {
        return [
            'Logo',
            'Name',
            'Description',
            'Rating',
            'Types',
            'Keywords',
            'Website',
            'Is ecommerce?',
            'City',
            'Address',
            'Phone',
            'Emails',
            'Taxs',
            'Workers',
            'Socials',
            'Date'
        ];
    }

    /**
    * @var Result $result
    */
    public function map($result): array
    {
        $workers = Person::where('organization_id', $result->organization_id)->get();
        $workers_data = [];
        foreach ($workers as $item) {
            $w_emails = [];
            foreach ($item->emails as $e) {
                array_push($w_emails, $e['value']);
            }
            $w_emails_data = implode(', ', $w_emails);
            array_push($workers_data, $item->name . '|' . $item->role . '|' . $w_emails_data);
        }
        $workers_data = implode(', ', $workers_data);

        $emails = Email::where('organization_id', $result->organization_id)->get();
        $emails_data = [];
        foreach ($emails as $item) {
            array_push($emails_data, $item->email);
        }
        $emails_data = implode(', ', $emails_data);

        $taxs = [];
        foreach ($result->organization->taxs as $item) {
            array_push($taxs, $item->tax);
        }
        $tax_list = implode(', ', $taxs);

        $socials = [];
        foreach ($result->organization->socials as $item) {
            array_push($socials, $item->url);
        }
        $socials_data = implode(', ', $socials);

        return [
            $result->organization->icon,
            $result->organization->title,
            $result->organization->description,
            $result->organization->rating,
            $result->organization->types,
            $result->organization->keywords,
            $result->organization->website,
            $result->organization->is_ecommerce == 1 ? 'Yes' : 'No',
            $result->organization->city,
            $result->organization->formatted_address,
            $result->organization->formatted_phone_number,
            $emails_data,
            $tax_list,
            $workers_data,
            $socials_data,
            $result->created_at
        ];
    }
}