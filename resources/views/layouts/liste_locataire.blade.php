@extends('layouts.master_dash')
@section('title', 'Gestion Agent Immobilier')
@section('content')
    <div class="container-xxl">

        {{-- <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Customers Details</h4>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table datatable" id="datatable_1">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Ext.</th>
                                        <th>City</th>
                                        <th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
                                        <th>Completion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Unity Pugh</td>
                                        <td>9958</td>
                                        <td>Curicó</td>
                                        <td>2005/02/11</td>
                                        <td>37%</td>
                                    </tr>
                                    <tr>
                                        <td>Theodore Duran</td>
                                        <td>8971</td>
                                        <td>Dhanbad</td>
                                        <td>1999/04/07</td>
                                        <td>97%</td>
                                    </tr>
                                    <tr>
                                        <td>Kylie Bishop</td>
                                        <td>3147</td>
                                        <td>Norman</td>
                                        <td>2005/09/08</td>
                                        <td>63%</td>
                                    </tr>
                                    <tr>
                                        <td>Willow Gilliam</td>
                                        <td>3497</td>
                                        <td>Amqui</td>
                                        <td>2009/29/11</td>
                                        <td>30%</td>
                                    </tr>
                                    <tr>
                                        <td>Blossom Dickerson</td>
                                        <td>5018</td>
                                        <td>Kempten</td>
                                        <td>2006/11/09</td>
                                        <td>17%</td>
                                    </tr>
                                    <tr>
                                        <td>Elliott Snyder</td>
                                        <td>3925</td>
                                        <td>Enines</td>
                                        <td>2006/03/08</td>
                                        <td>57%</td>
                                    </tr>
                                    <tr>
                                        <td>Castor Pugh</td>
                                        <td>9488</td>
                                        <td>Neath</td>
                                        <td>2014/23/12</td>
                                        <td>93%</td>
                                    </tr>
                                    <tr>
                                        <td>Pearl Carlson</td>
                                        <td>6231</td>
                                        <td>Cobourg</td>
                                        <td>2014/31/08</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>Deirdre Bridges</td>
                                        <td>1579</td>
                                        <td>Eberswalde-Finow</td>
                                        <td>2014/26/08</td>
                                        <td>44%</td>
                                    </tr>
                                    <tr>
                                        <td>Daniel Baldwin</td>
                                        <td>6095</td>
                                        <td>Moircy</td>
                                        <td>2000/11/01</td>
                                        <td>33%</td>
                                    </tr>
                                    <tr>
                                        <td>Pearl Carlson</td>
                                        <td>6231</td>
                                        <td>Cobourg</td>
                                        <td>2014/31/08</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div><!--end row--> --}}

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Export Table</h4>
                            </div><!--end col-->
                        </div> <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table datatable" id="datatable_2">
                                <thead class="">
                                    <tr>
                                        <th>Name</th>
                                        <th>Ext.</th>
                                        <th>City</th>
                                        <th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
                                        <th>Completion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Unity Pugh</td>
                                        <td>9958</td>
                                        <td>Curicó</td>
                                        <td>2005/02/11</td>
                                        <td>37%</td>
                                    </tr>
                                    <tr>
                                        <td>Theodore Duran</td>
                                        <td>8971</td>
                                        <td>Dhanbad</td>
                                        <td>1999/04/07</td>
                                        <td>97%</td>
                                    </tr>
                                    <tr>
                                        <td>Kylie Bishop</td>
                                        <td>3147</td>
                                        <td>Norman</td>
                                        <td>2005/09/08</td>
                                        <td>63%</td>
                                    </tr>
                                    <tr>
                                        <td>Willow Gilliam</td>
                                        <td>3497</td>
                                        <td>Amqui</td>
                                        <td>2009/29/11</td>
                                        <td>30%</td>
                                    </tr>
                                    <tr>
                                        <td>Blossom Dickerson</td>
                                        <td>5018</td>
                                        <td>Kempten</td>
                                        <td>2006/11/09</td>
                                        <td>17%</td>
                                    </tr>
                                    <tr>
                                        <td>Elliott Snyder</td>
                                        <td>3925</td>
                                        <td>Enines</td>
                                        <td>2006/03/08</td>
                                        <td>57%</td>
                                    </tr>
                                    <tr>
                                        <td>Castor Pugh</td>
                                        <td>9488</td>
                                        <td>Neath</td>
                                        <td>2014/23/12</td>
                                        <td>93%</td>
                                    </tr>
                                    <tr>
                                        <td>Pearl Carlson</td>
                                        <td>6231</td>
                                        <td>Cobourg</td>
                                        <td>2014/31/08</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>Deirdre Bridges</td>
                                        <td>1579</td>
                                        <td>Eberswalde-Finow</td>
                                        <td>2014/26/08</td>
                                        <td>44%</td>
                                    </tr>
                                    <tr>
                                        <td>Daniel Baldwin</td>
                                        <td>6095</td>
                                        <td>Moircy</td>
                                        <td>2000/11/01</td>
                                        <td>33%</td>
                                    </tr>
                                    <tr>
                                        <td>Pearl Carlson</td>
                                        <td>6231</td>
                                        <td>Cobourg</td>
                                        <td>2014/31/08</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-primary csv">Export CSV</button>
                            <button type="button" class="btn btn-sm btn-primary sql">Export SQL</button>
                            <button type="button" class="btn btn-sm btn-primary txt">Export TXT</button>
                            <button type="button" class="btn btn-sm btn-primary json">Export JSON</button>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div><!--end row-->
    </div><!-- container -->
    <!--Start Rightbar-->
    <!--Start Rightbar/offcanvas-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="Appearance" aria-labelledby="AppearanceLabel">
        <div class="offcanvas-header border-bottom justify-content-between">
            <h5 class="m-0 font-14" id="AppearanceLabel">Appearance</h5>
            <button type="button" class="btn-close text-reset p-0 m-0 align-self-center" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <h6>Account Settings</h6>
            <div class="p-2 text-start mt-3">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="settings-switch1">
                    <label class="form-check-label" for="settings-switch1">Auto updates</label>
                </div><!--end form-switch-->
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="settings-switch2" checked>
                    <label class="form-check-label" for="settings-switch2">Location Permission</label>
                </div><!--end form-switch-->
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="settings-switch3">
                    <label class="form-check-label" for="settings-switch3">Show offline Contacts</label>
                </div><!--end form-switch-->
            </div><!--end /div-->
            <h6>General Settings</h6>
            <div class="p-2 text-start mt-3">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="settings-switch4">
                    <label class="form-check-label" for="settings-switch4">Show me Online</label>
                </div><!--end form-switch-->
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="settings-switch5" checked>
                    <label class="form-check-label" for="settings-switch5">Status visible to all</label>
                </div><!--end form-switch-->
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="settings-switch6">
                    <label class="form-check-label" for="settings-switch6">Notifications Popup</label>
                </div><!--end form-switch-->
            </div><!--end /div-->
        </div><!--end offcanvas-body-->
    </div>
    <!--end Rightbar/offcanvas-->
    <!--end Rightbar-->
@endsection
