<?php

namespace App\Listeners;

use App\Events\CompanyCreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\SendCompanyCreationEmail;
use App\Mail\CompanyCreationEmail;
use App\Models\Api\Company;
use Illuminate\Support\Facades\Mail;
class CompanyCreateEventListener
{
    /**
     * Create the event listener.
     */
    /**
     * Handle the event.
     */
    public function handle(CompanyCreateEvent $event): void
    {
        $company = $event->company;
        $emailData = [
            'message'=>"$company->name is successfully created",
            'subject'=>'company Creation Email',
            'email'=>$company->email,
            'view_name'=>'emails.company_creation_email'
        ];
        Mail::to($company->email)->send(new CompanyCreationEmail($emailData));
    }
}
