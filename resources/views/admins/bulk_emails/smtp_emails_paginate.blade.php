<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Run Mode</th> 
                      <th>Mode</th> 
                      <th>Type</th> 
                      <th>Limit</th> 
                      <th>File ID</th> 
                      <th>Total Emails</th> 
                      <th>Created</th>
                      
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Run Mode</th> 
                      <th>Mode</th> 
                      <th>Type</th> 
                      <th>Limit</th> 
                      <th>File ID</th> 
                      <th>Total Emails</th> 
                      <th>Created</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  
                  @if(isset($pages) && $pages->count() > 0)
                  @foreach($pages as $key => $smtp)
                  @php
                  $isExists = 0;
                  $limit = $smtp->smtp_limit != "" ? $smtp->smtp_limit : '--';
                  $fileID = $smtp->file_id != "" ? $smtp->file_id : '--';
                  $totalEmails = Helper::getTotalEmailsByFileID($fileID);
                  $totalSend = Helper::getTotalSentEmail($smtp->file_id);
                  
                  $remaining = $totalEmails-$totalSend;
                  @endphp
                  <tr>
                    <td>{{ $key+1; }}</td>
                    <td>{{ $smtp->run_mode; }}</td>
                    <td>{{ $smtp->mode; }}</td>
                    <td>{{ $smtp->type; }}</td>
                    <td>{{ $limit; }}</td>
                    <td>{{ $fileID; }}</td>
                    <td>
                    Total Email: {{ $totalEmails; }}<br />
                    Total Sent: {{ $totalSend; }}<br />
                    Remaining: {{$remaining}}
                    </td>
                    <td>{{ date("F jS, Y",strtotime($smtp->created_at)); }}</td>
                    <td>
                    	@if($smtp->process == 0)
                    	<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_emails','1')" class="btn bg-blue waves-effect">Start</a>
                        @endif
                        @if($smtp->process == 1)
         				<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_emails','2')" class="btn bg-blue waves-effect">Pause</a>
                        <a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_emails','4')" class="btn bg-red waves-effect">Stop</a>               	
                        @endif

                        @if($smtp->process == 2)
                        	<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_emails','3')" class="btn bg-green waves-effect">Resume</a>
                        	<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_emails','4')" class="btn bg-red waves-effect">Stop</a>
                        @endif

                        @if($smtp->process == 3)
                        	<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_emails','2')" class="btn bg-blue waves-effect">Pause</a>
                        	<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_emails','4')" class="btn bg-red waves-effect">Stop</a>
                        @endif

                        @if($smtp->process == 4)
                        	<a href="javascript:void(0)"class="btn bg-red waves-effect">Stopped</a>
                        @endif
                        @if($smtp->process == 5)
                        	<a href="javascript:void(0)"class="btn bg-green waves-effect">Completed</a>
                        @endif
                        
                    </td>
                    <td><!--<a href="{{ url('admins/edit-smtp-email',Crypt::encrypt($smtp->id)) }}">
                      <button type="button" title="Edit" class="btn bg-blue waves-effect"> Edit </button>
                      </a>-->
                      <button onclick="deleteRecord('smtp_emails','{{ Crypt::encrypt($smtp->id) }}',{{ $isExists; }});" type="button" title="Delete" class="btn bg-red waves-effect"> Delete </button></td>
                  </tr>
                  @endforeach
                  
                  @else
                  <tr>
                    <td align="center" colspan="9">Record not found</td>
                  </tr>
                  @endif
                    </tbody>
                  
                </table>