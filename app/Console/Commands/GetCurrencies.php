<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Vyuldashev\XmlToArray\XmlToArray;

/**
 * Class GetCurrencies
 *
 * @package App\Console\Commands
 */
class GetCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all currencies  with api ';

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
        $currencies = json_decode(file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js'));

        $key = 0;
        foreach ($currencies->Valute as $currency) {
            $key++;
            Currency::updateOrCreate(
                [
                    'name' => $currency->Name,
                    'alphabetic_code' => $currency->CharCode,
                    'digit_code' => $currency->NumCode,
                    'rate' => $currency->Value,
                    'currency_id' => $currency->ID
                ]
            );
        }
        $this->getEnglishName();
    }


    private function getEnglishName()
    {
        $currencies_en = XmlToArray::convert(
            file_get_contents('https://www.cbr-xml-daily.ru/daily_eng_utf8.xml')
        );

        foreach($currencies_en['ValCurs']['Valute'] as $currency){
            Currency::all()->map(function($curr) use ($currency){
               if($curr->currency_id == $currency['_attributes']['ID'] ){
                   $curr->english_name = $currency['Name'];
                   $curr->save();
               };
            });
        }
    }
}
