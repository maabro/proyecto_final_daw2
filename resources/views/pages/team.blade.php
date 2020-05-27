@extends('layouts.main')

@section('title',$team->team_name)

@section('content')
<section class="team-content shadow-sm">
    <div class="row">
        <div class="col-xl-12">
            <div class="team-header mb-4">
                <img class="league-img" src="/img/shields/{{$team->team_img}}.png" alt="{{$team->team_img}}" width="90">
                <h1 class="league-name">{{$team->team_name}}</h1>
                <p class="league-country"><img src="/img/flags/{{$team->league->league_country_flag}}.png" alt="{{$team->league->league_country_flag}}" width="25"> {{$team->league->league_country}}</p> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mx-2 title-stat">Half-Time Statistics</h3>
            <div class="table-results p-2">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th class="text-center">Wins</th>
                            <th class="text-center">Draws</th>
                            <th class="text-center">Loses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-right"><b>Overall</b></td>
                            <td class="text-center border-right"><b>{{$team->home_ht['wins']+$team->away_ht['wins']}}</b></td>
                            <td class="text-center border-right"><b>{{$team->home_ht['draws']+$team->away_ht['draws']}}</b></td>
                            <td class="text-center"><b>{{$team->home_ht['loses']+$team->away_ht['loses']}}</b></td>
                        </tr>
                        <tr>
                            <td class="border-right">Home</td>
                            <td class="text-center border-right">{{$team->home_ht['wins']}}</td>
                            <td class="text-center border-right">{{$team->home_ht['draws']}}</td>
                            <td class="text-center">{{$team->home_ht['loses']}}</td>
                        </tr>
                        <tr>
                            <td class="border-right">Away</td>
                            <td class="text-center border-right">{{$team->away_ht['wins']}}</td>
                            <td class="text-center border-right">{{$team->away_ht['draws']}}</td>
                            <td class="text-center">{{$team->away_ht['loses']}}</td>
                        </tr>
                    </tbody>
                </table>            
            </div>
            <div class="table-scores p-2">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th class="text-center">GF</th>
                            <th class="text-center">GA</th>
                            <th class="text-center">AVG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-right"><b>Overall</b></td>
                            <td class="text-center border-right"><b>{{$team->goalavght['gf_total']}}</b></td>
                            <td class="text-center border-right"><b>{{$team->goalavght['ga_total']}}</b></td>
                            <td class="text-center"><b>{{$team->goalavght['gf_total']+$team->goalavght['ga_total']}}</b></td>
                        </tr>
                        <tr>
                            <td class="border-right">Home</td>
                            <td class="text-center border-right">{{$team->goalavght['gf_home']}}</td>
                            <td class="text-center border-right">{{$team->goalavght['ga_home']}}</td>
                            <td class="text-center">{{$team->goalavght['gf_home']+$team->goalavght['ga_home']}}</td>
                        </tr>
                        <tr>
                            <td class="border-right">Away</td>
                            <td class="text-center border-right">{{$team->goalavght['gf_away']}}</td>
                            <td class="text-center border-right">{{$team->goalavght['ga_away']}}</td>
                            <td class="text-center">{{$team->goalavght['gf_away']+$team->goalavght['ga_away']}}</td>
                        </tr>
                    </tbody>
                </table>            
            </div>
            <div class="row">
                <div class="col">
                    <div class="goals-table p-2">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" colspan="2"><i class="fas fa-futbol"></i> Over 0.5</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center fixed-size">{{$team->gl05['ht']}}% fh</td>
                                    <td class="text-center fixed-size">{{$team->gl05['ft']}}% sh</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col">
                    <div class="goals-table p-2">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" colspan="2"><i class="fas fa-futbol"></i> Over 1.5</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center fixed-size">{{$team->gl15['ht']}}% fh</td>
                                    <td class="text-center fixed-size">{{$team->gl15['ft']}}% sh</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col">
                    <div class="goals-table p-2">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" colspan="2"><i class="fas fa-futbol"></i> AVG goals</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center fixed-size">{{$team->goalavght['gf_total']+$team->goalavght['ga_total']}} ft</td>
                                    <td class="text-center fixed-size">- sh</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="bts-table p-2">
                <table class="table table-sm table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>BTS</th>
                            <th class="text-center">First time</th>
                            <th class="text-center">Second time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-right">Yes</td>
                            <td class="text-center border-right">{{$team->btsht['yes']}}%</td>
                            <td class="text-center">-</td>
                        </tr>
                        <tr>
                            <td class="border-right">No</td>
                            <td class="text-center border-right">{{$team->btsht['no']}}%</td>
                            <td class="text-center">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-6">
            <h3 class="mx-2 title-stat">Full-Time Statistics</h3>
            <div class="table-results p-2">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th class="text-center">Wins</th>
                            <th class="text-center">Draws</th>
                            <th class="text-center">Loses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-right"><b>Overall</b></td>
                            <td class="text-center border-right"><b>{{$team->home_ft['wins']+$team->away_ft['wins']}}</b></td>
                            <td class="text-center border-right"><b>{{$team->home_ft['draws']+$team->away_ft['draws']}}</b></td>
                            <td class="text-center"><b>{{$team->home_ft['loses']+$team->away_ft['loses']}}</b></td>
                        </tr>
                        <tr>
                            <td class="border-right">Home</td>
                            <td class="text-center border-right">{{$team->home_ft['wins']}}</td>
                            <td class="text-center border-right">{{$team->home_ft['draws']}}</td>
                            <td class="text-center">{{$team->home_ft['loses']}}</td>
                        </tr>
                        <tr>
                            <td class="border-right">Away</td>
                            <td class="text-center border-right">{{$team->away_ft['wins']}}</td>
                            <td class="text-center border-right">{{$team->away_ft['draws']}}</td>
                            <td class="text-center">{{$team->away_ft['loses']}}</td>
                        </tr>
                    </tbody>
                </table>            
            </div>
            <div class="table-scores p-2">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th class="text-center">GF</th>
                            <th class="text-center">GA</th>
                            <th class="text-center">AVG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-right"><b>Overall</td>
                            <td class="text-center border-right"><b>{{$team->goalavgft['gf_total']}}</b></td>
                            <td class="text-center border-right"><b>{{$team->goalavgft['ga_total']}}</b></td>
                            <td class="text-center"><b>{{$team->goalavgft['gf_total']+$team->goalavgft['ga_total']}}</b></td>
                        </tr>
                        <tr>
                            <td class="border-right">Home</td>
                            <td class="text-center border-right">{{$team->goalavgft['gf_home']}}</td>
                            <td class="text-center border-right">{{$team->goalavgft['ga_home']}}</td>
                            <td class="text-center">{{$team->goalavgft['gf_home']+$team->goalavgft['ga_home']}}</td>
                        </tr>
                        <tr>
                            <td class="border-right">Away</td>
                            <td class="text-center border-right">{{$team->goalavgft['gf_away']}}</td>
                            <td class="text-center border-right">{{$team->goalavgft['ga_away']}}</td>
                            <td class="text-center">{{$team->goalavgft['gf_away']+$team->goalavgft['ga_away']}}</td>
                        </tr>
                    </tbody>
                </table>            
            </div>
            <div class="row">
                <div class="col">
                    <div class="goals-table p-2">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center"><i class="fas fa-futbol"></i> Over 1.5</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">{{$team->ft15['ht']}}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col">
                    <div class="goals-table p-2">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center"><i class="fas fa-futbol"></i> Over 2.5</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">{{$team->ft25['ht']}}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col">
                    <div class="goals-table p-2">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center"><i class="fas fa-futbol"></i> AVG goals</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">{{$team->goalavgft['gf_total']+$team->goalavgft['ga_total']}}</td>
                                </tr>
                            </tbody>
                        </table>                            
                    </div>
                </div>                
            </div>
            <div class="bts-table p-2">
                <table class="table table-sm table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" colspan="2">BTS Full-time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center fixed-size">Yes</td>
                            <td class="text-center fixed-size">{{$team->btsft['yes']}}%</td>
                        </tr>
                        <tr>
                            <td class="text-center fixed-size">No</td>
                            <td class="text-center fixed-size">{{$team->btsft['no']}}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="corner-team p-2">
        <h3 class="title-stat mb-3">Corners market</h3>
        <div class="row">
            <div class="col-sm-6 col-xl-4">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" colspan="2">Over corners</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['over_corner'] as $corner)
                        <tr>
                            <td class="text-center fixed-size">{{$corner['name']}}</td>
                            <td class="text-center fixed-size">{{$corner['over']}}%</td>
                        </tr>
                    @endforeach    
                    </tbody>
                </table>
                <p>Over 7.5 ~ 13.5 Corners are calculated from total corners in a match that {{$team->team_name}} has participated.</p>
            </div>
            <div class="col-sm-6 col-xl-4">
            <table class="table table-sm table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" colspan="2">Corners for</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['corner_for'] as $cornerfor)
                        <tr>
                            <td class="text-center fixed-size">{{$cornerfor['name']}}</td>
                            <td class="text-center fixed-size">{{$cornerfor['over']}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p>Over 2.5 ~ 8.5 Corners For are calculated from corners that {{$team->team_name}} has won during a match.</p>          
            </div>
            <div class="col-sm-6 col-xl-4">
            <table class="table table-sm table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" colspan="2">Corners against</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['corner_against'] as $cornerag)
                        <tr>
                            <td class="text-center fixed-size">{{$cornerag['name']}}</td>
                            <td class="text-center fixed-size">{{$cornerag['over']}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p>Over 2.5 ~ 8.5 Corners Against are calculated from corners that {{$team->team_name}}'s opponent has won during a match.</p>          
            </div>
        </div>
    </div>
    <div class="card-team p-2">
        <h3 class="title-stat mb-3">Cards market</h3>
        <div class="row">
            <div class="col-sm-6 col-xl-4">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" colspan="2">Over cards</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['over_card'] as $card)
                        <tr>
                            <td class="text-center fixed-size">{{$card['name']}}</td>
                            <td class="text-center fixed-size">{{$card['over']}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p>Over 0.5 ~ 6.5 Cards are calculated from total cards in a match that {{$team->team_name}} has participated.</p>
            </div>
            <div class="col-sm-6 col-xl-4">
            <table class="table table-sm table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" colspan="2">Cards received</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['card_for'] as $cardfor)
                        <tr>
                            <td class="text-center fixed-size">{{$cardfor['name']}}</td>
                            <td class="text-center fixed-size">{{$cardfor['over']}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p>Over 0.5 ~ 6.5 Cards Received are calculated from cards that {{$team->team_name}} has received during a match.</p>          
            </div>
            <div class="col-sm-6 col-xl-4">
            <table class="table table-sm table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" colspan="2">Cards oponent</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team['card_against'] as $cardaga)
                        <tr>
                            <td class="text-center fixed-size">{{$cardaga['name']}}</td>
                            <td class="text-center fixed-size">{{$cardaga['over']}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p>Over 0.5 ~ 6.5 Cards Opponent are calculated from cards that {{$team->team_name}}'s opponent has received during a match.</p>          
            </div>
        </div>
    </div>
</section>
@endsection