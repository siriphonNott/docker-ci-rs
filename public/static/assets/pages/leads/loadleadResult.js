

let getContentLoadleadResult = (data, isSubmit = false) => {
    console.log(data);
    let submit = (isSubmit)?'':'nobody'
    let phoneBlockList = (data.hasOwnProperty('phoneBlockList')&&data.phoneBlockList!=0)?setContent(data.phoneBlockList):'No item'
    let duplicateTelList = (data.hasOwnProperty('duplicateTelList')&&data.duplicateTelList!=0)?setContent(data.duplicateTelList):'No item'
    let loadleadResult = setContentResult(data)
    let loadleadResultContect = `
    <div class="text-center upload-message ${submit}">
        <h2>Upload Successfully!</h2>
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#loadleadResult" data-toggle="tab" aria-expanded="false">Load Lead Result</a></li>
            <li class=""><a href="#duplicateTel" data-toggle="tab" aria-expanded="true">Duplicates List</a></li>
            <li class=""><a href="#phoneBlockList" data-toggle="tab" aria-expanded="true">Phone Block List</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="loadleadResult">
                ${loadleadResult}
            </div>

            <div class="tab-pane text-center" id="duplicateTel">
                ${duplicateTelList}
            </div>

            <div class="tab-pane text-center" id="phoneBlockList">
                ${phoneBlockList}
            </div>

        </div>
    </div>`;
    return loadleadResultContect;
}

let setContent = (data) => {
    console.log(data);
    let json = {};
    let content = `<div class="warning-content-box">`;
    content += `<table class="table table-bordered table-striped"><thead>
        <tr>
            <th><center>No</center></th>
            <th><center>Name</center></th>
            <th><center>Tel1</center></th>
        </tr>
    </thead>
    <tbody>`;
    data.forEach(element => {
        content += `<tr>`;
        content += `<td><center>${element.no}</center></td>`;
        content += `<td><center>${element.name}</center></td>`;
        content += `<td><center>${element.tel1}</center></td>`;
        content += `</tr>`;
    });
    content += `</tbody></table></div>`;
    return  content;
}

let setContentResult = (data) => {
    console.log(data);
    let json = {};
    let content = `<div class="warning-content-box">`;
    content += `<table class="table table-bordered table-striped"><thead>
        <tr>
            <th><center>TOTAL</center></th>
            <th><center>SUCCESS</center></th>
            <th><center>DUPLICATE</center></th>
            <th><center>BLOCK LIST</center></th>
        </tr>
    </thead>
    <tbody>`;
    content += `<tr>`;
    content += `<td class="bg-loadlead-result-total"><center>${data.totalNum}</center></td>`;
    content += `<td class="bg-loadlead-result-success"><center>${data.successNum}</center></td>`;
    content += `<td class="bg-loadlead-result-dup"><center>${data.duplicateTelNum}</center></td>`;
    content += `<td class="bg-loadlead-result-block"><center>${data.phoneBlockListNum}</center></td>`;
    content += `</tr>`;
    content += `</tbody></table></div>`;
    return  content;
}