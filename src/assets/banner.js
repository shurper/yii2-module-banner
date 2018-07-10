function updateAdsPlaceForm() {
    if ($('#adsplace-slider').is(':checked'))
        $('#adsplace-form-slider-block').show();
    else
        $('#adsplace-form-slider-block').hide();
}

$(document).on('change', '#adsplace-slider', function () {
    updateAdsPlaceForm();
})