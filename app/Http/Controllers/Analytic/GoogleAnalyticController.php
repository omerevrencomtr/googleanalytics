<?php

namespace App\Http\Controllers\Analytic;

use App\Model\Analytic\GoogleAnalytic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Analytics;
use Spatie\Analytics\Period;

class GoogleAnalyticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $client = new \GuzzleHttp\Client();

        $request = $client->get('https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A181045339&start-date=30daysAgo&end-date=yesterday&metrics=ga%3Asessions%2Cga%3Apageviews%2Cga%3AsessionsPerUser&dimensions=ga%3AdeviceCategory%2Cga%3Acity%2Cga%3Adate&access_token=ya29.GlwLB2R1oi1RS4xLEsfPBYo9F_aL9T-smCCmM6gQBElFutRppA4rM5e2npd3tpTCiKuSaDyczVswHzD02m1Ff-4uRXZaESn0XTCqTHUjUc0OrWgU1Xl5XNHmEgvahQ');

        if (!$request){
            return response()->json(['message'=> 'Veri getirilemedi'],422);
        }
        $response = $request->getBody()->getContents();

        $analyticsData=json_decode($response);



        /*
        $analyticsData = Analytics::performQuery(
            Period::years(1),
            'ga:sessions',
            [
                'metrics' => 'ga:sessions,ga:pageviews,ga:sessionsPerUser',
                'dimensions' => 'ga:deviceCategory,ga:city,ga:date'
            ]
        );

        */


        $googleAnalytic=new GoogleAnalytic;
        $googleAnalytic->name='rapor';
        $googleAnalytic->data=(string)json_encode($analyticsData);
        $googleAnalytic->save();

        if ($googleAnalytic){
            return response()->json(['message'=>'Kayıt başarılı'],200);
        }else{
            return response()->json(['message'=>'Kayıt başarısız'],422);
        }
        //return response()->json(['data'=>$analyticsData],200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=GoogleAnalytic::find($id);
        if (!$data){
            return response()->json(['message'=>'ID bulunamadı'],422);
        }
        return response()->json(['data'=>json_decode($data->data)],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
