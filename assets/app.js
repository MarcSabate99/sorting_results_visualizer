import './styles/app.scss';
import 'bootstrap'
import Swal from 'sweetalert2'

$(document).ready(function () {
    $('.js__horizontal__view').on('click', function () {
        $('.js_column_view').hide();
        $('.js_horizontal_view').show()
    });
    $('.js__vertical__view').on('click', function () {
        $('.js_column_view').show();
        $('.js_horizontal_view').hide()
    });

    $('.js__share').on('click', function () {
        let urlToCopy = $(this).data("url");
        let tempTextarea = $("<textarea>");
        tempTextarea.val(urlToCopy);
        $("body").append(tempTextarea);
        tempTextarea[0].select();
        tempTextarea[0].setSelectionRange(0, tempTextarea.val().length);
        try {
            document.execCommand('copy');
            showTooltip()
        } catch (err) {
            Swal.fire({
                title: 'Error!',
                text: "Error produced on copy url",
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        }

        tempTextarea.remove();
    });

    function showElements() {
        $('#results').show();
        const $horizontalView = $('.js_horizontal_view');
        const $columnView = $('.js_column_view');
        $horizontalView.empty();
        $horizontalView.show();
        $columnView.empty();
        $columnView.hide();
        $('.tooltip').css('display', 'inline-block')
        return {$horizontalView, $columnView};
    }

    $('.js__visualize').on('click', function () {
       let files = $('.js_file')[0].files;
       let formData = new FormData();
       let file = files[0];
       if(typeof file === "undefined") {
           Swal.fire({
               title: 'Error!',
               text: "No file provided",
               icon: 'error',
               confirmButtonText: 'Ok'
           })
           return;
       }
       formData.append('file', file, file.name);
       $.ajax({
           type: 'POST',
           url: '/generate/visualizer',
           data: formData,
           contentType: false,
           processData: false,
           success: function(response) {
               loadPage(response)
           },
           error: function(error) {
               Swal.fire({
                   title: 'Error!',
                   text: error.message,
                   icon: 'error',
                   confirmButtonText: 'Ok'
               })
           }
       });
    })
    function showTooltip() {
        const $toolTipText = $(".tooltip .tooltip-text");
        $toolTipText.text("URL copied!");
        $toolTipText.css('visibility', "visible")
        $toolTipText.css('opacity', 1)
        setTimeout(function() {
            $toolTipText.text("Click to copy the url")
            $toolTipText.css('visibility', "hidden")
            $toolTipText.css('opacity', 0)
        }, 2000);
    }
    function getOtherFields(item) {
        return Object.keys(item.others).map(function (key) {
            return `<p>${key}:  ${item.others[key]}</p>`;
        }).join('');
    }

    function getHighlighted(item) {
        let highlighted = 'box';
        if (item.highlighted === "1") {
            highlighted = 'box-highlighted'
        }
        return highlighted;
    }

    function renderHorizontal(item) {
        let otherKeysHtml = getOtherFields(item);
        let highlighted = getHighlighted(item);
        return `
            <div class="row ${highlighted}">
                <div class="row__img__container">
                    <img src="${item.imageUrl}" alt="${item.title}">
                </div>
                <div class="row__content__container">
                    <h3>${item.title}</h3>
                    ${otherKeysHtml}
                </div>
            </div>
        `;
    }

    function renderColumn(item) {
        let otherKeysHtml = getOtherFields(item);
        let highlighted = getHighlighted(item);

        return `
            <div class="col ${highlighted}">
                <img src="${item.imageUrl}" alt="${item.title}">
                <div class="col__content__container">
                    <h3>${item.title}</h3>
                    ${otherKeysHtml}
                </div>
            </div>
        `;
    }

    function loadPage(data) {
        const {$horizontalView, $columnView} = showElements();
        $('.js__share').data('url', data.sortingShareUrl)
        data.data.forEach(function(item) {
            let columnItem = renderColumn(item);
            $columnView.append(columnItem);
            let horizontalItem = renderHorizontal(item);
            $horizontalView.append(horizontalItem);
        });
    }

    function renderData(){
        let urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('data')) {
            let data = urlParams.get('data');
            let jsonData = JSON.parse(data)
            let realData = {}
            if(typeof jsonData !== "undefined" && jsonData != null && jsonData.length > 0) {
                realData.data = jsonData
                realData.sortingShareUrl = window.location.href
                loadPage(realData);
            }
        }
    }
    renderData()
});