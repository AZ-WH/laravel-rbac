<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use App\Models\AdminUrl;

class routeToSql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route-to-sql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将路由信息保存到数据库';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $command =  __DIR__ . "/../../../artisan route:list --path='admin'";

        $routeList = shell_exec($command);

        $routeList = explode("\n" , $routeList);

        $count = count($routeList);
        unset($routeList[0]);
        unset($routeList[1]);
        unset($routeList[2]);
        unset($routeList[$count - 1]);
        unset($routeList[$count - 2]);

        $adminUrlModel = new AdminUrl();

        foreach ($routeList as $r){
            $rList = explode("| " ,$r);
            $method = trim($rList[2]);
            $url = trim($rList[3]);

            $isHave = AdminUrl::where('url' , $url)->where('method' , $method)->get()->toArray();
            if(empty($isHave)){
                try{
                    DB::table($adminUrlModel->getTable())->insert([
                        'url'       => $url,
                        'method'    => $method
                    ]);
                    echo "添加了{$url} {$method} 到admin_url表中\n";

                }catch (\Exception $e){
                    var_dump($e);
                }


            }

        }

    }


}
