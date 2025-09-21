<?php

namespace Database\Seeders;

use App\Models\SubService;
use App\Models\MenuServices;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuService = MenuServices::create([
            'name' => 'Latte Legalizations',
            'description' => 'Drafting of documents such as letters, special power of attorneys, promissory notes, compromise agreements, and others..',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create SubServices under this Menu Service
        $subServices = [
            'Simple Documents (Jurat) – ₱1,000.00 (₱500.00 notarization only)',
            'Acknowledgement of Power of Attorney / Ordinary Documents – ₱2,000.00 minimum or ₱500.00 per page (₱1,000.00 if notarization only)',
            'Authentication & Certification of Documents / Statements – ₱500.00 minimum or ₱100.00 per page',
            'Preparation & Notarization of Judicial Affidavits – ₱5,000.00 minimum or ₱1,000.00 per page',
            'Preparation & Notarization of Resolutions / Certifications / Minutes of Meetings (SEC) – ₱3,000.00 minimum or ₱1,000.00 per page',
        ];

        foreach ($subServices as $details) {
            SubService::create([
                'details' => $details,
                'menu_services_id' => $menuService->id,
            ]);
        }

        $menuService = MenuServices::create([
            'name' => 'Espresso Advise',
            'description' => 'Online consultations with the lawyer.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create SubServices under this Menu Service
        $subServices = [
            'Plain Consultation (Office / Virtual) – ₱1,000.00 per hour',
            'Physical Consultation (Outside Office) – ₱2,000.00 per hour',
            'Consultation with Written Advice / Opinion – ₱2,000.00 or ₱1,000.00 per page',
            'Preparation & Notarization of Judicial Affidavits – ₱5,000.00 minimum or ₱1,000.00 per page',
            'Research or Preliminary Study – ₱1,500.00 per hour ',
        ];

        foreach ($subServices as $details) {
            SubService::create([
                'details' => $details,
                'menu_services_id' => $menuService->id,
            ]);
        }

        $menuService = MenuServices::create([
            'name' => 'Barista Grind',
            'description' => 'Thorough research and analysis of legal issues, study of applicable laws and statutes, and provision of legal documentation and research services.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create SubServices under this Menu Service
        $subServices = [
            'Preparation of Attorney’s Letter – ₱1,500.00 or 1% of value stated in letter',
            'Drafting of Position Papers & Memoranda (Labor/Administrative Case) – ₱10,000.00 minimum or ₱1,000.00 per page',
            'Drafting of Position Papers & Memoranda (Civil/Criminal Case) – ₱15,000.00 minimum or ₱1,000.00 per page',
            'Drafting of Position Papers & Memoranda (On Appeal) – ₱20,000.00 minimum or ₱1,000.00 per page',
            'Drafting & Submission of Motions (Litigious) – ₱10,000.00 ',
            'Drafting & Submission of Motions (Non-Litigious) – ₱5,000.00',
            'Written Manifestations – ₱5,000.00',
            'Motion for Reconsideration / New Trial – ₱10,000.00',
        ];

        foreach ($subServices as $details) {
            SubService::create([
                'details' => $details,
                'menu_services_id' => $menuService->id,
            ]);
        }

        $menuService = MenuServices::create([
            'name' => 'Americano Agreements',
            'description' => 'Drafting of contracts; review of existing contracts and drafting of revised contract.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create SubServices under this Menu Service
        $subServices = [
            'Contracts / Agreement of Sale (Real or Personal Property) – 3% of contract amount (minimum ₱3,000.00)',
            'Contracts not involving sale – ₱3,000.00 or ₱500.00 per page',
            'Retainership (₱5M capital & below) – ₱10,000.00/month',
            'Retainership (₱5M+ capital) – ₱25,000.00/month',
            'Appointment as Corporate Secretary – ₱20,000.00/month (non-listed) / ₱50,000.00/month (publicly listed)',
            'Appointment as Corporate Representative (Foreign Corporations) – ₱100,000.00/month',
            'SEC Registration (Articles of Inc / Partnership / By-Laws) – ₱15,000.00–₱35,000.00 depending on type',
            'Engagement in SEC Cases – ₱40,000.00',
        ];

        foreach ($subServices as $details) {
            SubService::create([
                'details' => $details,
                'menu_services_id' => $menuService->id,
            ]);
        }

        $menuService = MenuServices::create([
            'name' => 'Cappuccino Case Files',
            'description' => 'Assistance with litigation of cases, including court representation and preparation of pleadings in the areas of: Labor law, Marriage and family relations, Property law, Corporate law, Immigration law',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create SubServices under this Menu Service
        $subServices = [
            'Civil/Criminal Acceptance Fees: * MTC / MTCC – ₱50,000.00, RTC – ₱80,000.00 (civil) / ₱70,000.00 (criminal), CA / CTA – ₱100,000.00, Sandiganbayan – ₱200,000.00, Supreme Court – ₱250,000.00',
            'Special Proceedings: Change of Name / Correction / Recognition of Judgment – ₱50,000.00, Domestic Adoption – ₱100,000.00, Adoption w/ Foreigners – ₱200,000.00, Foreclosure of Mortgage – ₱50,000.00, Settlement of Estate – ₱50,000.00, Naturalization – ₱170,000.00',
            'Appearance Fees (per hearing): ₱1,000.00 – ₱25,000.00 depending on court',
        ];

        foreach ($subServices as $details) {
            SubService::create([
                'details' => $details,
                'menu_services_id' => $menuService->id,
            ]);
        }

        $menuService = MenuServices::create([
            'name' => 'Mocha Labor Matters',
            'description' => 'Labor-related cases',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create SubServices under this Menu Service
        $subServices = [
            'Before Labor Arbiter – ₱3,000.00 or ₱1,000.00/hour',
            'Before NLRC / DOLE Regional Office / Voluntary Arbitrator – ₱4,000.00 or ₱1,500.00/hour',
            'DOLE National Office Hearings – ₱10,000.00 or ₱2,500.00/hour',
            'Collective Bargaining Agreement Negotiation – ₱75,000.00 or ₱2,500.00/hour',
            'Petition for Injunction (NLRC) – ₱40,000.00',
            'Petition for Certification of Labor Dispute (DOLE Sec.) – ₱60,000.00',
        ];

        foreach ($subServices as $details) {
            SubService::create([
                'details' => $details,
                'menu_services_id' => $menuService->id,
            ]);
        }

        $menuService = MenuServices::create([
            'name' => 'Macchiato Government Engagements',
            'description' => 'Ombudsman, DOJ, agencies, IP, immigration',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create SubServices under this Menu Service
        $subServices = [
            'Ombudsman – ₱3,000.00 or ₱1,000.00/hour',
            'City/Provincial Prosecutor – ₱3,000.00 or ₱1,000.00/hour',
            'Regional State Prosecutor – ₱3,500.00 or ₱1,500.00/hour',
            'Other Admin Agencies (DAR, BI, SEC, SSS, etc.) – ₱4,000.00 or ₱1,500.00/hour',
            'IPO (Patents, Trademarks, Copyrights) – ₱150,000.00 (per IPOPHL schedule)',
            'Immigration Proceedings – ₱50,000.00',
            'Investigative Commissions / Law Enforcement Agencies – ₱50,000.00',
        ];

        foreach ($subServices as $details) {
            SubService::create([
                'details' => $details,
                'menu_services_id' => $menuService->id,
            ]);
        }

        $menuService = MenuServices::create([
            'name' => 'Affogato Property & Estate',
            'description' => 'Real estate, wills, titles',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create SubServices under this Menu Service
        $subServices = [
            'Testate / Intestate Proceedings (Settlement of Estate): With Opposition – ₱200,000.00 or 10% FMV of property, Without Opposition – ₱75,000.00 or 5% FMV of property',
            'Land Registration – ₱150,000.00 or 5% FMV',
            'Due Diligence (Real Property): ₱20,000.00 (simple) / ₱50,000.00 (complex)',
            'Petition for Reconstitution of Title – ₱75,000.00',
            'Petition for Issuance of New Owner’s Duplicate Title – ₱50,000.00',
        ];

        foreach ($subServices as $details) {
            SubService::create([
                'details' => $details,
                'menu_services_id' => $menuService->id,
            ]);
        }
    }
}
