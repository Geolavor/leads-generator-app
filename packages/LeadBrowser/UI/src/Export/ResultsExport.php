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
            'organization', 'organization.taxs', 'organization.socials',
            'organization.technologies', 'organization.emails', 'organization.persons'
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
            'Classification',
            'Keywords',
            'Website',
            'Is ecommerce?',
            'City',
            'Address',
            'Phone',
            'Emails',
            'Taxs',
            'Employees',
            'Socials',
            'Technology',
            'Domain created',
            'Domain expires',
            'Domain owner',
            'Website Archive',
            'Date'
        ];
    }

    /**
    * @var Result $result
    */
    public function map($result): array
    {
        $employees = Person::where('organization_id', $result->organization_id)->get();
        $employees_data = [];
        foreach ($employees as $item) {
            $w_emails = [];
            foreach ($item->emails as $e) {
                array_push($w_emails, $e['value']);
            }
            $w_emails_data = implode('| ', $w_emails);
            array_push($employees_data, $item->name . '|' . $item->role . '|' . $w_emails_data);
        }
        $employees_data = implode(', ', $employees_data);

        $emails = Email::where('organization_id', $result->organization_id)->get();
        $emails_data = [];
        foreach ($emails as $item) {
            array_push($emails_data, $item->email);
        }
        $emails_data = implode(', ', $emails_data);

        $taxs = [];
        if (isset($result->organization->taxs)) {
            foreach ($result->organization->taxs as $item) {
                array_push($taxs, $item->tax);
            }
        }
        $tax_list = implode(', ', $taxs);

        $socials = [];
        if (isset($result->organization->socials)) {
            foreach ($result->organization->socials as $item) {
                array_push($socials, $item->url);
            }
        }
        $socials_data = implode(', ', $socials);

        $technologies = [];
        if (isset($result->organization->technologies)) {
            foreach ($result->organization->technologies as $item) {
                array_push($technologies, $item->type);
            }
        }
        $technologies_data = implode(', ', $technologies);

        // TODO
        // $archives = [];
        // if (isset($result->organization->archive)) {
        //     foreach ($result->organization->archive as $item) {
        //         array_push($archives, $item['time']['date']);
        //     }
        // }
        // $archives_data = implode(', ', $archives);


        return [
            $result->organization->icon,
            $result->organization->title,
            $result->organization->description,
            $result->organization->rating,
            $result->organization->types,
            $result->organization->classification,
            $result->organization->keywords,
            $result->organization->website,
            $result->organization->is_ecommerce == 1 ? 'Yes' : 'No',
            $result->organization->city,
            $result->organization->formatted_address,
            $result->organization->formatted_phone_number,
            $emails_data,
            $tax_list,
            $employees_data,
            $socials_data,
            $technologies_data,
            $result->organization->domain_created,
            $result->organization->domain_expires,
            $result->organization->domain_owner,
            [],//$archives_data,
            $result->created_at
        ];
    }
}