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
    const $shareBtn = $('.js__share');

    $shareBtn.on('click', function () {
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
        resetCurrentSorting();
        readCSV();
    })

    function resetCurrentSorting() {
        const url = new URL(window.location.href);
        const path = url.pathname;
        let newPath = path.substring(0, path.lastIndexOf('/'));
        if (!newPath.endsWith('/')) {
            newPath += '/';
        }
        window.history.replaceState({}, document.title, url.origin + newPath);
        $('.js__share').hide();
    }

    function createShareButton(data) {
        $.ajax({
            type: 'POST',
            url: '/generate/visualizer',
            data: JSON.stringify(data),
            contentType: false,
            processData: false,
            success: function(response) {
                $('.js__share').data('url', response.sortingShareUrl);
                $('.js__share').show();
            }
        })
    }

    function readCSV() {
        const file = $('.js_file')[0].files[0];
        if (!file) {
            Swal.fire({
                title: 'Error!',
                text: "No file provided",
                icon: 'error',
                confirmButtonText: 'Ok'
            })
            return;
        }

        if(file.type !== "text/csv") {
            Swal.fire({
                title: 'Error!',
                text: "Invalid file type",
                icon: 'error',
                confirmButtonText: 'Ok'
            })
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            const content = event.target.result;
            const data = parseCSV(content);
            if (checkRequiredFields(data)) {
                const transformedData = transformToJSON(data);
                let elements = {elements: transformedData};
                loadPage(elements)
                createShareButton(elements)
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: "Missing required fields: title or imageUrl",
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            }
        };

        reader.readAsText(file);
    }
    function checkRequiredFields(data) {
        for (const row of data) {
            if (!row.title || !row.imageUrl) {
                return false;
            }
        }
        return true;
    }
    function parseCSV(csvContent) {
        const data = [];
        const lines = csvContent.trim().split('\n');
        const keys = lines.shift().split(',');

        for (const line of lines) {
            const values = line.split(',');
            const transformedRow = Object.fromEntries(keys.map((key, index) => [key, values[index]]));
            data.push(transformedRow);
        }
        return data;
    }

    function transformToJSON(data) {
        const transformedData = [];

        for (const row of data) {
            const jsonRow = {
                title: row.title.replace(/"/g, ''),
                imageUrl: row.imageUrl.replace(/"/g, ''),
                others: {}
            };

            for (const key in row) {
                if (key !== "title" && key !== "imageUrl") {
                    jsonRow.others[key.trim()] = row[key].replace(/"/g, '');
                }
            }
            transformedData.push(jsonRow);
        }

        return transformedData;
    }

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
            if(key !== "highlighted") {
                return `<p>${key}:  ${item.others[key]}</p>`;
            }
        }).join('');
    }

    function getHighlighted(item) {
        let highlighted = 'box';
        if (item.others.highlighted.trim() === "1") {
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
        $('.js__share').data('url', data.sortingShareUrl);
        data.elements.forEach(function(item) {
            let columnItem = renderColumn(item);
            $columnView.append(columnItem);
            let horizontalItem = renderHorizontal(item);
            $horizontalView.append(horizontalItem);
        });
    }

    function renderData(){
        const sortingData = $('#sorting_data').val()
        const data  = JSON.parse(sortingData);
        if(data.length === 0) {
            return;
        }
        let realData = {}
        realData.elements = JSON.parse(sortingData)
        realData.sortingShareUrl = window.location.href
        loadPage(realData);
        $shareBtn.data('url', realData.sortingShareUrl);
        $shareBtn.show();
    }

    renderData()
});