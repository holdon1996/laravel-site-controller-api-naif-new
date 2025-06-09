<?php

namespace ThachVd\LaravelSiteControllerApi\Console\Commands;

use ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln\TlLincolnService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use ThachVd\LaravelSiteControllerApi\Services\Sc\TlLincoln\TlLincolnSoapService;

class MasterRoomTypeFromTlLincoln extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:MasterRoomTypeFromTlLincoln';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get master room type TL-Lincoln';
    protected $tlLincolnService;

    public function __construct(TlLincolnSoapService $tlLincolnService)
    {
        parent::__construct();
        $this->tlLincolnService = $tlLincolnService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("■■■ MasterRoomTypeFromTlLincoln Start ■■■");
        $this->info("■■■ MasterRoomTypeFromTlLincoln Start ■■■");

        $time = new \DateTime();
        $time->modify('-10 minutes');
        $requestData['searchTimeFrom'] = $time->format('Y-m-d\TH:i:s');
        $this->tlLincolnService->getRoomType($requestData);

        Log::info("■■■ MasterRoomTypeFromTlLincoln End ■■■");
        $this->info("■■■ MasterRoomTypeFromTlLincoln End ■■■");
    }
}
