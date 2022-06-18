<?php

namespace App\Http\Controllers;
use App\Models\Member;
use App\Models\Players;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SnsController extends Controller
{
    public function snsAll()
    {
        $credentials_path = storage_path('app/json/credentials.json');
        $client = new \Google_Client();
        $client->setScopes([
            \Google_Service_Sheets::SPREADSHEETS,
            \Google_Service_Sheets::DRIVE, 
        ]);
        $client->setAuthConfig($credentials_path);
        $spreadsheet_service = new \Google_Service_Sheets($client);

        $TWsheet_id = '1GhtCo0kSexw7-ckjrIgZOuj5GbWBcQgfajTXlPPPp7Q';
        $TWrange = 'combineList!E1:E11'; 
        $TWresponse = $spreadsheet_service->spreadsheets_values->get($TWsheet_id, $TWrange);
        $TWvalues = $TWresponse->getValues();
        $TWlist = array();
        for($i = 0; $i < 11; $i++){
            if($TWvalues[$i][0]=="TRUE"){
                if($i!=10){
                    $TWMember = Member::find($i+1)->toArray();
                    $TWvalue = $TWvalues[$i];
                    $TWvalue[] = $TWMember;
                }else{
                    $TWMember = array('display'=>'いせぶい公式','ImageCol'=>'#FEDF0D');
                    $TWvalue = $TWvalues[$i];
                    $TWvalue[] = $TWMember;
                    $offTWres = $spreadsheet_service->spreadsheets_values->get($TWsheet_id, 'combineList!A11:G11');
                    $offTWValues = $offTWres->getValues();
                    $officialTW = $offTWValues[0];
                    $TWvalue[] = $officialTW;
                }
                $TWlist[] = $TWvalue;
            }
        }

        $YTsheet_id = '1Bnl5N666vtcRiHlq-yqpn-oOMekW1KdI4uV_5wMhDQk';
        $YTrange = 'combineList!F1:F11'; 
        $YTresponse = $spreadsheet_service->spreadsheets_values->get($YTsheet_id, $YTrange);
        $YTvalues = $YTresponse->getValues();
        $YTlist = array();
        for($j = 0; $j < 11; $j++){
            if($YTvalues[$j][0]=="TRUE"){
                if($j!=10){
                    $YTMember = Member::find($j+1)->toArray();
                    $YTvalue = $YTvalues[$j];
                    $YTvalue[] = $YTMember;
                }else{
                    $YTMember = array('display'=>'いせぶい公式','ImageCol'=>'#FEDF0D');
                    $YTvalue = $YTvalues[$j];
                    $YTvalue[] = $YTMember;
                    $offYTres = $spreadsheet_service->spreadsheets_values->get($YTsheet_id, 'combineList!A11:H11');
                    $offYTValues = $offYTres->getValues();
                    $officialYT = $offYTValues[0];
                    $YTvalue[] = $officialYT;
                }
                $YTlist[] = $YTvalue;
            }
        }

        return response()->json(
            [
                'YTlist' => $YTlist,
                'TWlist' => $TWlist,
            ]
        );
    }
    public function snsFull()
    {
        $credentials_path = storage_path('app/json/credentials.json');
        $client = new \Google_Client();
        $client->setScopes([
            \Google_Service_Sheets::SPREADSHEETS,
            \Google_Service_Sheets::DRIVE, 
        ]);
        $client->setAuthConfig($credentials_path);
        $spreadsheet_service = new \Google_Service_Sheets($client);

        $TWsheet_id = '1GhtCo0kSexw7-ckjrIgZOuj5GbWBcQgfajTXlPPPp7Q';
        $TWrange = 'combineList!A1:G11'; 
        $TWresponse = $spreadsheet_service->spreadsheets_values->get($TWsheet_id, $TWrange);
        $TWvalues = $TWresponse->getValues();
        $TWlist = array();
        for($i = 0; $i < 11; $i++){
                if($i!=10){
                    $TWMember = Member::where('id', $i+1)->select('display','ENname')->get()->toArray();
                    $TWvalue = array($TWvalues[$i][0],$TWvalues[$i][1],$TWvalues[$i][6]);
                    $TWvalue[] = $TWMember[0];
                }else{
                    $TWMember = array('display'=>'いせぶい公式','ENname'=>'iseV info');
                    $TWvalue = array($TWvalues[$i][0],$TWvalues[$i][1],$TWvalues[$i][6]);
                    $TWvalue[] = $TWMember;
                }
                $TWlist[] = $TWvalue;
        }

        $YTsheet_id = '1Bnl5N666vtcRiHlq-yqpn-oOMekW1KdI4uV_5wMhDQk';
        $YTrange = 'combineList!A1:H11'; 
        $YTresponse = $spreadsheet_service->spreadsheets_values->get($YTsheet_id, $YTrange);
        $YTvalues = $YTresponse->getValues();
        $YTlist = array();
        for($j = 0; $j < 11; $j++){
                if($j!=10){
                    $YTMember = Member::where('id', $j+1)->select('display','ENname')->get()->toArray();
                    $YTvalue = array($YTvalues[$j][1],$YTvalues[$j][2],$YTvalues[$j][7]);
                    $YTvalue[] = $YTMember[0];
                }else{
                    $YTMember =array('display'=>'いせぶい公式','ENname'=>'iseV info');
                    $YTvalue = array($YTvalues[$j][1],$YTvalues[$j][2],$YTvalues[$j][7]);
                    $YTvalue[] = $YTMember;
                }
                $YTlist[] = $YTvalue;
        }

        return response()->json(
            [
                'YTlist' => $YTlist,
                'TWlist' => $TWlist,
            ]
        );
    }
    public function snsMember($id)
    {
        $credentials_path = storage_path('app/json/credentials.json');
        $client = new \Google_Client();
        $client->setScopes([
            \Google_Service_Sheets::SPREADSHEETS,
            \Google_Service_Sheets::DRIVE, 
        ]);
        $client->setAuthConfig($credentials_path);
        $spreadsheet_service = new \Google_Service_Sheets($client);

        $SNSinfo = array();

        $TWsheet_id = '1GhtCo0kSexw7-ckjrIgZOuj5GbWBcQgfajTXlPPPp7Q';
        $TWrange = str('combineList!A'.str($id).':G'); 
        $TWresponse = $spreadsheet_service->spreadsheets_values->get($TWsheet_id, $TWrange);
        $TWvalue = $TWresponse->getValues();

        $YTsheet_id = '1Bnl5N666vtcRiHlq-yqpn-oOMekW1KdI4uV_5wMhDQk';
        $YTrange = str('combineList!A'.str($id).':H'); 
        $YTresponse = $spreadsheet_service->spreadsheets_values->get($YTsheet_id, $YTrange);
        $YTvalue = $YTresponse->getValues();

        if($YTvalue[0][5]=="TRUE"){
            $SNSinfo[0]=$YTvalue[0];
        }else{
            $SNSinfo[0]=null;
        }
        if($TWvalue[0][4]=="TRUE"){
            $SNSinfo[1]=$TWvalue[0];
        }else{
            $SNSinfo[1]=null;
        }

        return response()->json(
            [
                'SNSinfo' => $SNSinfo,
            ]
        );
    }
    
    public function getStatus()
    {
        $live = DB::connection('mysql_liveinfo')->table('stock')
                    ->where('status','2')
                    ->join('member','stock.member_id','=','member.id')
                    ->select('stock.*','member.display','member.MainCol','member.ImageCol','member.ENname')
                    ->get();
        $schedule = DB::connection('mysql_liveinfo')->table('stock')
                    ->where('status','1')
                    ->orderBy('schedule', 'asc')
                    ->join('member','stock.member_id','=','member.id')
                    ->select('stock.*','member.display','member.MainCol','member.ImageCol','member.ENname')
                    ->get();
        
        return response()->json(
            [
                'live' => $live,
                'schedule' => $schedule,
            ]
        );
    }
    public function getLiveInfo()
    {
        $live = DB::connection('mysql_liveinfo')->table('stock')
                    ->where('status','2')
                    ->join('member','stock.member_id','=','member.id')
                    ->select('stock.*','member.display','member.ENname')
                    ->get();
        $schedule = DB::connection('mysql_liveinfo')->table('stock')
                    ->where('status','1')
                    ->orderBy('schedule', 'asc')
                    ->join('member','stock.member_id','=','member.id')
                    ->select('stock.*','member.display','member.ENname')
                    ->get();
        
        return response()->json(
            [
                'live' => $live,
                'schedule' => $schedule,
            ]
        );
    }
}
