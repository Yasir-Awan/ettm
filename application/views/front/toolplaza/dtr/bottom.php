<div class="col-md-4 pr-1 wrap-input-container">
        <label>Upload Signed File<span class="text-danger">* (Only PDF and Image is allowed)</span></label>
        <input class="file-upload form-control required" name="dtr_file" type="file"  accept="application/pdf,image/*">
    </div>
    <div class="col-md-2 pr-1 wrap-input-container">
        <a href="javascript:void(0);" class="btn btn-sm btn-warning pull-right" title="Add Excempt" onclick="addexempt();" data-toggle="tooltip">
            <i class="fa fa-plus" aria-hidden="true"></i> Add Exempt
        </a>
    </div>
</div>
<div id="dynamicexempt"></div>
<div class="row">
    <div class="col-md-6 pr-1">
        <div class="form-group">
            <label>Supporting document name <span class="text-info">(Optional)</optional></label>
            <input type="text" name="suppporting_document_name[]" id="supporting_0" class="form-control classes" placeholder="Enter File Name" min="0">
        </div>
    </div>
    <div class="col-md-4 pr-1 wrap-input-container">
        <label>Supporting  File(<span class="text-info">Optional &nbsp;Only PDF,Excel and Image is allowed</span>)</label>
        <input class="file-upload form-control" name="supporting_file[]" type="file"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ,application/pdf,image/*">                      
    </div>
    <div class="col-md-2 pr-1 wrap-input-container">
        <a href="javascript:void(0);" class="btn btn-sm btn-info pull-right" title="Add More File" onclick="addFormulaProcedures();" data-toggle="tooltip">
            <i class="fa fa-plus" aria-hidden="true"></i> Add More File 
        </a>
    </div>
</div>
<div id="dynamicInput2"></div>
<div class="clearfix"></div>
<input type="hidden" name="theValue" id="theValue" value="0"/>
<input type="hidden" name="theValue2" id="theValue2" value="0"/>
<!-- <input type="hidden" name="theValue11" id="theValue11" value="0"/>
<input type="hidden" name="theValue222" id="theValue222" value="0"/> -->
    <div class="row">
    
    <input type="hidden" name="add_exempt" id="add_exempt" value="0">
    <div class="col-md-12 pr-1 wrap-input-container">
        <span class="btn btn-info btn-block pull-right" onclick="form_submit('add_dtr');">Add</span>
    </div>
    </div>