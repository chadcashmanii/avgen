/**
 * Variables
 */
var userItems;
var userId  = 1;
var imageI = 0;
var urlBegin = "";
var imgLoc  = 'images/avatar/';

// Element Variables
var ToolsTab        = $("#tools");
var ShirtsTab       = $("#shirts");
var PantsTab        = $("#pants");
var ShoesTab        = $("#shoes");
var EquippedList    = $("#equipped-list");
var RemoveItemBtn   = $("#remove-item");
var RemoveAllBtn    = $("#remove-all");
var AvatarLoading = $("#avatar-loading");
var UserImg = $("#user-img");
var UserImgSpace = $("#user-img-space");


// Creates Avatar Image
var createAvatarImage = function() {
    UserImgSpace.hide();
    var imgSrc  = urlBegin+'/images/users/user_'+userId+'.png';
    UserImg.attr("src", imgSrc+"?i="+imageI);
    UserImgSpace.show();
    imageI++;
};

// Equips Item
var equipItem = function(itemId) {
    AvatarLoading.show();
    $.get("avatar/"+userId+"/add/"+itemId, function(data, status) {
        startUp();
        AvatarLoading.hide();
    });
};

// Turns Array to Options (must use id and title keys for value and label)
var arrayToOptions = function(selectOptions, SelectInput, defaultLabel) {
    SelectInput.html("");
    SelectInput.append(
        $('<option></option>').html(defaultLabel)
    );
    $.each(selectOptions, function(key, value) {
        SelectInput.append(
            $('<option></option>').val(value.id).html(value.title)
        );
    });
};

// Creates a Thumbnail with Avatar Item Obj Data
var createItemThumbnail = function(item) {
    var imgSrc  = imgLoc + item.group_title + '/' + item.filename + '_thumb.png';
    var html    = '<div class="col-xs-6 col-sm-3 thumbnail">';
    html        += '<a onclick="equipItem('+item.iuid+')" title="Add '+item.title+'">';
    html        += '<img src="'+imgSrc+'" alt="'+item.title+' Thumbnail" />'
    html        += '</a>';
    html        += '</div>';
    return html;
};

var getGroupThumbnails = function(items, GroupTab) {
    var html = "";
    $.each(items, function(index, value) {
        html += createItemThumbnail(value);
    });
    GroupTab.html(html);
};

// Gets Removable Equipped Items
var getEquippedItems = function() {
    var items = false;
    $.get(urlBegin+"/items/user/"+userId, function(data,status){
        //alert("Data: " + data + "\nStatus: " + status);
        arrayToOptions(data, EquippedList, "Equipped Items");
    });
};

// Gets Removable Items By Group
var getItemsByGroup = function(group, GroupTab) {
    $.get(urlBegin+"/items/"+group+"/user/"+userId, function(data,status){
        getGroupThumbnails(data, GroupTab);
    });
};

var startUp = function() {
    createAvatarImage();
    getEquippedItems(userId);
    getItemsByGroup(4, ShirtsTab);
    getItemsByGroup(5, PantsTab);
    getItemsByGroup(7, ShoesTab);
};

// Removes Single Items
var removeItem = function(itemId) {
    AvatarLoading.show();
    $.get(urlBegin+"/avatar/"+userId+"/remove/"+itemId, function(data, status){
        startUp();
        AvatarLoading.hide();
    });
};

// Removes All Items
var removeItems = function() {
    AvatarLoading.show();
    $.get(urlBegin+"/avatar/"+userId+"/remove", function(data,status){
        startUp();
        AvatarLoading.hide();
    });
    createAvatarImage();
};

// Remove Loading Bar
AvatarLoading.hide();

$(document).ready(function() {
    /**
     * Events
     */
    // On Load
    startUp();

    // Events
    RemoveAllBtn.click(function() {
        removeItems();
        startUp();
    });

    RemoveItemBtn.click(function() {
        removeItem(EquippedList.val());
        startUp();
    });
});