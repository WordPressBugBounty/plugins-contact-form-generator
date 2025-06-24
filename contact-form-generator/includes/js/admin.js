(function($) {

window.cfgDash = function(options) {

	var $this = this,
        thisPage = this;

    this.initVars = function() {

        // console.clear();

        // get options
        this.options = options;
        this.is_touch_devise = 'ontouchstart' in window ? true : false;
        this.timeouts = {};

        var svg_inner = 'role="img" xmlns="http://www.w3.org/2000/svg"';
        this.svgs = {
            'lang': '<svg class="ss_svg_globe" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M504 256C504 118.815 392.705 8 256 8 119.371 8 8 118.74 8 256c0 136.938 111.041 248 248 248 136.886 0 248-110.987 248-248zm-41.625 64h-99.434c6.872-42.895 6.6-86.714.055-128h99.38c12.841 41.399 12.843 86.598-.001 128zM256.001 470.391c-30.732-27.728-54.128-69.513-67.459-118.391h134.917c-13.332 48.887-36.73 90.675-67.458 118.391zM181.442 320c-7.171-41.387-7.349-85.537.025-128h149.067c7.371 42.453 7.197 86.6.025 128H181.442zM256 41.617c33.557 30.295 55.554 74.948 67.418 118.383H188.582c11.922-43.649 33.98-88.195 67.418-118.383zM449.544 160h-93.009c-10.928-44.152-29.361-83.705-53.893-114.956C366.825 59.165 420.744 101.964 449.544 160zM209.357 45.044C184.826 76.293 166.393 115.847 155.464 160H62.456C91.25 101.975 145.162 59.169 209.357 45.044zM49.625 192h99.38c-6.544 41.28-6.818 85.1.055 128H49.625c-12.842-41.399-12.844-86.598 0-128zm12.831 160h93.122c11.002 44.176 29.481 83.824 53.833 114.968C144.875 452.786 91.108 409.738 62.456 352zm240.139 114.966c24.347-31.138 42.825-70.787 53.827-114.966h93.121c-28.695 57.827-82.504 100.802-146.948 114.966z"></path></svg>',
            'back': '<svg class="ss_svg_back" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M11.5 280.6l192 160c20.6 17.2 52.5 2.8 52.5-24.6V96c0-27.4-31.9-41.8-52.5-24.6l-192 160c-15.3 12.8-15.3 36.4 0 49.2zm256 0l192 160c20.6 17.2 52.5 2.8 52.5-24.6V96c0-27.4-31.9-41.8-52.5-24.6l-192 160c-15.3 12.8-15.3 36.4 0 49.2z"></path></svg>',
            'forw': '<svg class="ss_svg_forw" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M500.5 231.4l-192-160C287.9 54.3 256 68.6 256 96v320c0 27.4 31.9 41.8 52.5 24.6l192-160c15.3-12.8 15.3-36.4 0-49.2zm-256 0l-192-160C31.9 54.3 0 68.6 0 96v320c0 27.4 31.9 41.8 52.5 24.6l192-160c15.3-12.8 15.3-36.4 0-49.2z"></path></svg>',
            'loading': '<svg class="ss_svg_loading" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M456.433 371.72l-27.79-16.045c-7.192-4.152-10.052-13.136-6.487-20.636 25.82-54.328 23.566-118.602-6.768-171.03-30.265-52.529-84.802-86.621-144.76-91.424C262.35 71.922 256 64.953 256 56.649V24.56c0-9.31 7.916-16.609 17.204-15.96 81.795 5.717 156.412 51.902 197.611 123.408 41.301 71.385 43.99 159.096 8.042 232.792-4.082 8.369-14.361 11.575-22.424 6.92z"></path></svg>',
            'users': '<svg class="ss_svg_users" '+svg_inner+' viewBox="0 0 640 512"><path fill="currentColor" d="M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM609.3 512H471.4c5.4-9.4 8.6-20.3 8.6-32v-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2h61.4C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z"></path></svg>',
            't': '<svg class="ss_svg_t" '+svg_inner+' viewBox="0 0 384 512"><path fill="currentColor" d="M32 32C14.3 32 0 46.3 0 64S14.3 96 32 96H160V448c0 17.7 14.3 32 32 32s32-14.3 32-32V96H352c17.7 0 32-14.3 32-32s-14.3-32-32-32H192 32z"></path></svg>',
            'download': '<svg class="ss_svg_download" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24zm296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path></svg>',
            'group': '<svg class="ss_svg_group" '+svg_inner+' viewBox="0 0 576 512"><path fill="currentColor" d="M32 119.4C12.9 108.4 0 87.7 0 64C0 28.7 28.7 0 64 0c23.7 0 44.4 12.9 55.4 32H456.6C467.6 12.9 488.3 0 512 0c35.3 0 64 28.7 64 64c0 23.7-12.9 44.4-32 55.4V392.6c19.1 11.1 32 31.7 32 55.4c0 35.3-28.7 64-64 64c-23.7 0-44.4-12.9-55.4-32H119.4c-11.1 19.1-31.7 32-55.4 32c-35.3 0-64-28.7-64-64c0-23.7 12.9-44.4 32-55.4V119.4zM456.6 96H119.4c-5.6 9.7-13.7 17.8-23.4 23.4V392.6c9.7 5.6 17.8 13.7 23.4 23.4H456.6c5.6-9.7 13.7-17.8 23.4-23.4V119.4c-9.7-5.6-17.8-13.7-23.4-23.4zM128 160c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V160zM256 320h32c35.3 0 64-28.7 64-64V224h64c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V320z"></path></svg>',
            'ungroup': '<svg class="ss_svg_ungroup" '+svg_inner+' viewBox="0 0 640 512"><path fill="currentColor" d="M32 119.4C12.9 108.4 0 87.7 0 64C0 28.7 28.7 0 64 0c23.7 0 44.4 12.9 55.4 32H328.6C339.6 12.9 360.3 0 384 0c35.3 0 64 28.7 64 64c0 23.7-12.9 44.4-32 55.4V232.6c19.1 11.1 32 31.7 32 55.4c0 35.3-28.7 64-64 64c-23.7 0-44.4-12.9-55.4-32H119.4c-11.1 19.1-31.7 32-55.4 32c-35.3 0-64-28.7-64-64c0-23.7 12.9-44.4 32-55.4V119.4zM119.4 96c-5.6 9.7-13.7 17.8-23.4 23.4V232.6c9.7 5.6 17.8 13.7 23.4 23.4H328.6c5.6-9.7 13.7-17.8 23.4-23.4V119.4c-9.7-5.6-17.8-13.7-23.4-23.4H119.4zm192 384c-11.1 19.1-31.7 32-55.4 32c-35.3 0-64-28.7-64-64c0-23.7 12.9-44.4 32-55.4V352h64v40.6c9.7 5.6 17.8 13.7 23.4 23.4H520.6c5.6-9.7 13.7-17.8 23.4-23.4V279.4c-9.7-5.6-17.8-13.7-23.4-23.4h-46c-5.4-15.4-14.6-28.9-26.5-39.6V192h72.6c11.1-19.1 31.7-32 55.4-32c35.3 0 64 28.7 64 64c0 23.7-12.9 44.4-32 55.4V392.6c19.1 11.1 32 31.7 32 55.4c0 35.3-28.7 64-64 64c-23.7 0-44.4-12.9-55.4-32H311.4z"></path></svg>',
            'speaker': '<svg class="ss_svg_speaker" '+svg_inner+' viewBox="0 0 576 512"><path fill="currentColor" d="M256 88.017v335.964c0 21.438-25.943 31.998-40.971 16.971L126.059 352H24c-13.255 0-24-10.745-24-24V184c0-13.255 10.745-24 24-24h102.059l88.971-88.954c15.01-15.01 40.97-4.49 40.97 16.971zm182.056-77.876C422.982.92 403.283 5.668 394.061 20.745c-9.221 15.077-4.473 34.774 10.604 43.995C468.967 104.063 512 174.983 512 256c0 73.431-36.077 142.292-96.507 184.206-14.522 10.072-18.129 30.01-8.057 44.532 10.076 14.528 30.016 18.126 44.531 8.057C529.633 438.927 576 350.406 576 256c0-103.244-54.579-194.877-137.944-245.859zM480 256c0-68.547-36.15-129.777-91.957-163.901-15.076-9.22-34.774-4.471-43.994 10.607-9.22 15.078-4.471 34.774 10.607 43.994C393.067 170.188 416 211.048 416 256c0 41.964-20.62 81.319-55.158 105.276-14.521 10.073-18.128 30.01-8.056 44.532 6.216 8.96 16.185 13.765 26.322 13.765a31.862 31.862 0 0 0 18.21-5.709C449.091 377.953 480 318.938 480 256zm-96 0c0-33.717-17.186-64.35-45.972-81.944-15.079-9.214-34.775-4.463-43.992 10.616s-4.464 34.775 10.615 43.992C314.263 234.538 320 244.757 320 256a32.056 32.056 0 0 1-13.802 26.332c-14.524 10.069-18.136 30.006-8.067 44.53 10.07 14.525 30.008 18.136 44.53 8.067C368.546 316.983 384 287.478 384 256z"></path></svg>',
            'speaker_empty': '<svg class="ss_svg_speaker_empty" '+svg_inner+' viewBox="0 0 576 512"><path fill="currentColor" d="M576 256c0 100.586-53.229 189.576-134.123 239.04-7.532 4.606-17.385 2.241-21.997-5.304-4.609-7.539-2.235-17.388 5.304-21.997C496.549 424.101 544 345.467 544 256c0-89.468-47.452-168.101-118.816-211.739-7.539-4.609-9.913-14.458-5.304-21.997 4.608-7.539 14.456-9.914 21.997-5.304C522.77 66.424 576 155.413 576 256zm-96 0c0-66.099-34.976-124.572-88.133-157.079-7.538-4.611-17.388-2.235-21.997 5.302-4.61 7.539-2.236 17.388 5.302 21.998C418.902 152.963 448 201.134 448 256c0 54.872-29.103 103.04-72.828 129.779-7.538 4.61-9.912 14.459-5.302 21.998 4.611 7.541 14.462 9.911 21.997 5.302C445.024 380.572 480 322.099 480 256zm-138.14-75.117c-7.538-4.615-17.388-2.239-21.998 5.297-4.612 7.537-2.241 17.387 5.297 21.998C341.966 218.462 352 236.34 352 256s-10.034 37.538-26.841 47.822c-7.538 4.611-9.909 14.461-5.297 21.998 4.611 7.538 14.463 9.909 21.998 5.297C368.247 314.972 384 286.891 384 256s-15.753-58.972-42.14-75.117zM256 88.017v335.964c0 21.436-25.942 31.999-40.971 16.971L126.059 352H24c-13.255 0-24-10.745-24-24V184c0-13.255 10.745-24 24-24h102.059l88.971-88.954C230.037 56.038 256 66.551 256 88.017zm-32 19.311l-77.659 77.644A24.001 24.001 0 0 1 129.372 192H32v128h97.372a24.001 24.001 0 0 1 16.969 7.028L224 404.67V107.328z"></path></svg>',
            'muted': '<svg class="ss_svg_muted" '+svg_inner+' viewBox="0 0 640 512"><path fill="currentColor" d="M219.845 98.213l27.184-27.167C262.04 56.036 288 66.556 288 88.017v62.623l-68.155-52.427zm195.889 150.684c-2.233-30.88-18.956-58.492-45.706-74.842-13.987-8.547-31.941-5.071-41.824 7.51l87.53 67.332zM436.665 64.74C500.967 104.063 544 174.983 544 256a223.67 223.67 0 0 1-14.854 80.137l52.417 40.321C598.735 339.19 608 298.184 608 256c0-103.244-54.579-194.877-137.944-245.859-15.074-9.221-34.773-4.473-43.995 10.604-9.221 15.077-4.473 34.774 10.604 43.995zm-50.009 81.961C425.067 170.188 448 211.048 448 256c0 5.676-.39 11.301-1.128 16.849l55.604 42.772A191.69 191.69 0 0 0 512 256c0-68.547-36.15-129.777-91.957-163.901-15.076-9.22-34.774-4.471-43.994 10.607-9.22 15.078-4.471 34.775 10.607 43.995zM90.232 160H56c-13.255 0-24 10.745-24 24v144c0 13.255 10.745 24 24 24h102.059l88.97 88.951c15.028 15.028 40.971 4.467 40.971-16.97V312.129L90.232 160zm360.889 277.607c-1.205.871-2.403 1.75-3.627 2.599-14.522 10.072-18.129 30.01-8.057 44.532 10.076 14.528 30.016 18.125 44.531 8.057a289.026 289.026 0 0 0 19.578-14.861l-52.425-40.327zm-71.629-55.099c-1.263 7.875.389 16.229 5.294 23.3 6.216 8.96 16.185 13.765 26.322 13.765 4.387 0 8.8-.923 12.959-2.776l-44.575-34.289zm255.53 107.442c8.071-10.493 6.123-25.54-4.356-33.63L48.389 4.978c-10.506-8.082-25.574-6.116-33.656 4.39L4.978 22.05c-8.082 10.506-6.116 25.574 4.39 33.656l582.208 451.29c10.505 8.111 25.598 6.156 33.69-4.364l9.756-12.682z"></path></svg>',
            'close': '<svg class="ss_svg_close" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm101.8-262.2L295.6 256l62.2 62.2c4.7 4.7 4.7 12.3 0 17l-22.6 22.6c-4.7 4.7-12.3 4.7-17 0L256 295.6l-62.2 62.2c-4.7 4.7-12.3 4.7-17 0l-22.6-22.6c-4.7-4.7-4.7-12.3 0-17l62.2-62.2-62.2-62.2c-4.7-4.7-4.7-12.3 0-17l22.6-22.6c4.7-4.7 12.3-4.7 17 0l62.2 62.2 62.2-62.2c4.7-4.7 12.3-4.7 17 0l22.6 22.6c4.7 4.7 4.7 12.3 0 17z"></path></svg>',
            'lines': '<svg class="ss_svg_lines" '+svg_inner+' viewBox="0 0 448 512"><path fill="currentColor" d="M0 84V44c0-8.837 7.163-16 16-16h416c8.837 0 16 7.163 16 16v40c0 8.837-7.163 16-16 16H16c-8.837 0-16-7.163-16-16zm16 144h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 256h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0-128h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg>',
            'dots': '<svg class="ss_svg_dots" '+svg_inner+' viewBox="0 0 448 512"><path fill="currentColor" d="M120 256c0 30.9-25.1 56-56 56s-56-25.1-56-56s25.1-56 56-56s56 25.1 56 56zm160 0c0 30.9-25.1 56-56 56s-56-25.1-56-56s25.1-56 56-56s56 25.1 56 56zm104 56c-30.9 0-56-25.1-56-56s25.1-56 56-56s56 25.1 56 56s-25.1 56-56 56z"/></svg>',
            'hand': '<svg class="ss_svg_hand" '+svg_inner+' viewBox="0 0 448 512"><path fill="currentColor" d="M208 288C199.2 288 192 295.2 192 304v96C192 408.8 199.2 416 208 416s16-7.164 16-16v-96C224 295.2 216.8 288 208 288zM272 288C263.2 288 256 295.2 256 304v96c0 8.836 7.162 16 15.1 16S288 408.8 288 400l-.0013-96C287.1 295.2 280.8 288 272 288zM376.9 201.2c-13.74-17.12-34.8-27.45-56.92-27.45h-13.72c-3.713 0-7.412 .291-11.07 .8652C282.7 165.1 267.4 160 251.4 160h-11.44V72c0-39.7-32.31-72-72.01-72c-39.7 0-71.98 32.3-71.98 72v168.5C84.85 235.1 75.19 235.4 69.83 235.4c-44.35 0-69.83 37.23-69.83 69.85c0 14.99 4.821 29.51 13.99 41.69l78.14 104.2C120.7 489.3 166.2 512 213.7 512h109.7c6.309 0 12.83-.957 18.14-2.645c28.59-5.447 53.87-19.41 73.17-40.44C436.1 446.3 448 416.2 448 384.2V274.3C448 234.6 416.3 202.3 376.9 201.2zM400 384.2c0 19.62-7.219 38.06-20.44 52.06c-12.53 13.66-29.03 22.67-49.69 26.56C327.4 463.6 325.3 464 323.4 464H213.7c-32.56 0-63.65-15.55-83.18-41.59L52.36 318.2C49.52 314.4 48.02 309.8 48.02 305.2c0-16.32 14.5-21.75 21.72-21.75c4.454 0 12.01 1.55 17.34 8.703l28.12 37.5c3.093 4.105 7.865 6.419 12.8 6.419c11.94 0 16.01-10.7 16.01-16.01V72c0-13.23 10.78-24 23.1-24c13.22 0 24 10.77 24 24v130.7c0 6.938 5.451 16.01 16.03 16.01C219.5 218.7 220.1 208 237.7 208h13.72c21.5 0 18.56 19.21 34.7 19.21c8.063 0 9.805-5.487 20.15-5.487h13.72c26.96 0 17.37 27.43 40.77 27.43l14.07-.0037c13.88 0 25.16 11.28 25.16 25.14V384.2zM336 288C327.2 288 320 295.2 320 304v96c0 8.836 7.164 16 16 16s16-7.164 16-16v-96C352 295.2 344.8 288 336 288z"/></svg>',
            'house': '<svg class="ss_svg_hause" '+svg_inner+' viewBox="0 0 576 512"><path fill="currentColor" d="M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L512 185V64c0-17.7-14.3-32-32-32H448c-17.7 0-32 14.3-32 32v36.7L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1h32v69.7c-.1 .9-.1 1.8-.1 2.8V472c0 22.1 17.9 40 40 40h16c1.2 0 2.4-.1 3.6-.2c1.5 .1 3 .2 4.5 .2H160h24c22.1 0 40-17.9 40-40V448 384c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v64 24c0 22.1 17.9 40 40 40h24 32.5c1.4 0 2.8 0 4.2-.1c1.1 .1 2.2 .1 3.3 .1h16c22.1 0 40-17.9 40-40V455.8c.3-2.6 .5-5.3 .5-8.1l-.7-160.2h32z"/></svg>',
            'check_double': '<svg class="ss_svg_check_double" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M374.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 178.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l80 80c12.5 12.5 32.8 12.5 45.3 0l160-160zm96 128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 402.7 86.6 297.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l256-256z"/></svg>',
            'circle_play': '<svg class="ss_svg_circle_play" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M188.3 147.1C195.8 142.8 205.1 142.1 212.5 147.5L356.5 235.5C363.6 239.9 368 247.6 368 256C368 264.4 363.6 272.1 356.5 276.5L212.5 364.5C205.1 369 195.8 369.2 188.3 364.9C180.7 360.7 176 352.7 176 344V167.1C176 159.3 180.7 151.3 188.3 147.1V147.1zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/></svg>',
            'play': '<svg class="ss_svg_play" '+svg_inner+' viewBox="0 0 384 512"><path fill="currentColor" d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg>',
            'email': '<svg class="ss_svg_email" '+svg_inner+' viewBox="0 0 640 512"><path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0l57.4-43c23.9-59.8 79.7-103.3 146.3-109.8l13.9-10.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176V384c0 35.3 28.7 64 64 64H360.2C335.1 417.6 320 378.5 320 336c0-5.6 .3-11.1 .8-16.6l-26.4 19.8zM640 336a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zm-76.7-43.3c6.2 6.2 6.2 16.4 0 22.6l-72 72c-6.2 6.2-16.4 6.2-22.6 0l-40-40c-6.2-6.2-6.2-16.4 0-22.6s16.4-6.2 22.6 0L480 353.4l60.7-60.7c6.2-6.2 16.4-6.2 22.6 0z"/></svg>',
            'video': '<svg class="ss_svg_video" '+svg_inner+' viewBox="0 0 576 512"><path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"/></svg>',
            'users_g': '<svg class="ss_svg_users_g" '+svg_inner+' viewBox="0 0 640 512"><path fill="currentColor" d="M144 160c-44.2 0-80-35.8-80-80S99.8 0 144 0s80 35.8 80 80s-35.8 80-80 80zm368 0c-44.2 0-80-35.8-80-80s35.8-80 80-80s80 35.8 80 80s-35.8 80-80 80zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM416 224c0 53-43 96-96 96s-96-43-96-96s43-96 96-96s96 43 96 96zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>',
            'chart_line': '<svg class="ss_svg_chart_line" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64V400c0 44.2 35.8 80 80 80H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H80c-8.8 0-16-7.2-16-16V64zm406.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L320 210.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L240 221.3l57.4 57.4c12.5 12.5 32.8 12.5 45.3 0l128-128z"/></svg>',
            'table': '<svg class="ss_svg_table" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm88 64v64H64V96h88zm56 0h88v64H208V96zm240 0v64H360V96h88zM64 224h88v64H64V224zm232 0v64H208V224h88zm64 0h88v64H360V224zM152 352v64H64V352h88zm56 0h88v64H208V352zm240 0v64H360V352h88z"/></svg>',
            'heart': '<svg class="ss_svg_heart" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/></svg>',
            'cloud': '<svg class="ss_svg_cloud" '+svg_inner+' viewBox="0 0 640 512"><path fill="currentColor" d="M0 336c0 79.5 64.5 144 144 144H512c70.7 0 128-57.3 128-128c0-61.9-44-113.6-102.4-125.4c4.1-10.7 6.4-22.4 6.4-34.6c0-53-43-96-96-96c-19.7 0-38.1 6-53.3 16.2C367 64.2 315.3 32 256 32C167.6 32 96 103.6 96 192c0 2.7 .1 5.4 .2 8.1C40.2 219.8 0 273.2 0 336z"/></svg>',
            'microphone': '<svg class="ss_svg_microphone" '+svg_inner+' viewBox="0 0 384 512"><path fill="currentColor" d="M96 96V256c0 53 43 96 96 96s96-43 96-96H208c-8.8 0-16-7.2-16-16s7.2-16 16-16h80V192H208c-8.8 0-16-7.2-16-16s7.2-16 16-16h80V128H208c-8.8 0-16-7.2-16-16s7.2-16 16-16h80c0-53-43-96-96-96S96 43 96 96zM320 240v16c0 70.7-57.3 128-128 128s-128-57.3-128-128V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 89.1 66.2 162.7 152 174.4V464H120c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H216V430.4c85.8-11.7 152-85.3 152-174.4V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v24z"/></svg>',
            'user_c': '<svg class="ss_svg_user_c" '+svg_inner+' viewBox="0 0 640 512"><path fill="currentColor" d="M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM625 177L497 305c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L591 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>',
            'user_x': '<svg class="ss_svg_user_x" '+svg_inner+' viewBox="0 0 640 512"><path fill="currentColor" d="M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM471 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>',
            'paint': '<svg class="ss_svg_paint" '+svg_inner+' viewBox="0 0 576 512"><path fill="currentColor" d="M371.3 367.1c27.3-3.9 51.9-19.4 67.2-42.9L600.2 74.1c12.6-19.5 9.4-45.3-7.6-61.2S549.7-4.4 531.1 9.6L294.4 187.2c-24 18-38.2 46.1-38.4 76.1L371.3 367.1zm-19.6 25.4l-116-104.4C175.9 290.3 128 339.6 128 400c0 3.9 .2 7.8 .6 11.6c1.8 17.5-10.2 36.4-27.8 36.4H96c-17.7 0-32 14.3-32 32s14.3 32 32 32H240c61.9 0 112-50.1 112-112c0-2.5-.1-5-.2-7.5z"/></svg>',
            'images': '<svg class="ss_svg_images" '+svg_inner+' viewBox="0 0 576 512"><path fill="currentColor" d="M160 32c-35.3 0-64 28.7-64 64V320c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H160zM396 138.7l96 144c4.9 7.4 5.4 16.8 1.2 24.6S480.9 320 472 320H328 280 200c-9.2 0-17.6-5.3-21.6-13.6s-2.9-18.2 2.9-25.4l64-80c4.6-5.7 11.4-9 18.7-9s14.2 3.3 18.7 9l17.3 21.6 56-84C360.5 132 368 128 376 128s15.5 4 20 10.7zM256 128c0 17.7-14.3 32-32 32s-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120V344c0 75.1 60.9 136 136 136H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H136c-48.6 0-88-39.4-88-88V120z"/></svg>',
            'dice': '<svg class="ss_svg_dice" '+svg_inner+' viewBox="0 0 448 512"><path fill="currentColor" d="M216.3 2c4.8-2.6 10.5-2.6 15.3 0L422.3 106c5.1 2.8 8.3 8.2 8.3 14s-3.2 11.2-8.3 14L231.7 238c-4.8 2.6-10.5 2.6-15.3 0L25.7 134c-5.1-2.8-8.3-8.2-8.3-14s3.2-11.2 8.3-14L216.3 2zM23.7 170l176 96c5.1 2.8 8.3 8.2 8.3 14V496c0 5.6-3 10.9-7.8 13.8s-10.9 3-15.8 .3L8.3 414C3.2 411.2 0 405.9 0 400V184c0-5.6 3-10.9 7.8-13.8s10.9-3 15.8-.3zm400.7 0c5-2.7 11-2.6 15.8 .3s7.8 8.1 7.8 13.8V400c0 5.9-3.2 11.2-8.3 14l-176 96c-5 2.7-11 2.6-15.8-.3s-7.8-8.1-7.8-13.8V280c0-5.9 3.2-11.2 8.3-14l176-96z"/></svg>',
            'blog': '<svg class="ss_svg_dice" '+svg_inner+' viewBox="0 0 448 512"><path fill="currentColor" d="M192 32c0 17.7 14.3 32 32 32c123.7 0 224 100.3 224 224c0 17.7 14.3 32 32 32s32-14.3 32-32C512 128.9 383.1 0 224 0c-17.7 0-32 14.3-32 32zm0 96c0 17.7 14.3 32 32 32c70.7 0 128 57.3 128 128c0 17.7 14.3 32 32 32s32-14.3 32-32c0-106-86-192-192-192c-17.7 0-32 14.3-32 32zM96 144c0-26.5-21.5-48-48-48S0 117.5 0 144V368c0 79.5 64.5 144 144 144s144-64.5 144-144s-64.5-144-144-144H128v96h16c26.5 0 48 21.5 48 48s-21.5 48-48 48s-48-21.5-48-48V144z"/></svg>',
            'case': '<svg class="ss_svg_dice" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M184 48H328c4.4 0 8 3.6 8 8V96H176V56c0-4.4 3.6-8 8-8zm-56 8V96H64C28.7 96 0 124.7 0 160v96H192 320 512V160c0-35.3-28.7-64-64-64H384V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56zM512 288H320v32c0 17.7-14.3 32-32 32H224c-17.7 0-32-14.3-32-32V288H0V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V288z"/></svg>',
            'arrow_right': '<svg class="ss_svg_dice" '+svg_inner+' viewBox="0 0 512 512"><path fill="currentColor" d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>',
            'grip': '<svg class="ss_svg_grip" '+svg_inner+' viewBox="0 0 448 512"><path fill="currentColor" d="M128 136c0-22.1-17.9-40-40-40L40 96C17.9 96 0 113.9 0 136l0 48c0 22.1 17.9 40 40 40H88c22.1 0 40-17.9 40-40V136zm0 192c0-22.1-17.9-40-40-40H40c-22.1 0-40 17.9-40 40v48c0 22.1 17.9 40 40 40H88c22.1 0 40-17.9 40-40V328zm32-192v48c0 22.1 17.9 40 40 40h48c22.1 0 40-17.9 40-40V136c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40zM288 328c0-22.1-17.9-40-40-40H200c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40h48c22.1 0 40-17.9 40-40V328zm32-192v48c0 22.1 17.9 40 40 40h48c22.1 0 40-17.9 40-40V136c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40zM448 328c0-22.1-17.9-40-40-40H360c-22.1 0-40 17.9-40 40v48c0 22.1 17.9 40 40 40h48c22.1 0 40-17.9 40-40V328z"/></svg>'
        };
    };

	this.applyAdminFunction = function() {

		/////////////////////////////////////////////////////////////////////////TASKS///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//check/uncheck all
		$("#wpcfg_check_all").click(function() {
			if($(this).is(":checked")) {
				$('.wpcfg_row_ch').attr('checked',true);
			}
			else {
				$('.wpcfg_row_ch').attr('checked',false);
			}
			
			wpcfg_check_the_selection();
		});
		
		//unpublish task
		$(".wpcfg_unpublish").click(function() {
			var id = $(this).attr("wpcfg_id");
			$("#wpcfg_def_id").val(id);
			$("#wpcfg_task").val('unpublish');
			$("#wpcfg_form").submit();
			return false;
		});
		//publish task
		$(".wpcfg_publish").click(function() {
			var id = $(this).attr("wpcfg_id");
			$("#wpcfg_def_id").val(id);
			$("#wpcfg_task").val('publish');
			$("#wpcfg_form").submit();
			return false;
		});
		//publish list task
		$("#wpcfg_publish_list").click(function(e) {
			e.preventDefault();
			var l = parseInt($('.wpcfg_row_ch:checked').length);
			if(l > 0) {
				$("#wpcfg_task").val('publish');
				$("#wpcfg_form").submit();
				return false;
			}
			else {
				alert('Please first make a selection from the list');
				return false;
			}
		});
		//unpublish list task
		$("#wpcfg_unpublish_list").click(function(e) {
			e.preventDefault();
			var l = parseInt($('.wpcfg_row_ch:checked').length);
			if(l > 0) {
				$("#wpcfg_task").val('unpublish');
				$("#wpcfg_form").submit();
				return false;
			}
			else {
				alert('Please first make a selection from the list');
				return false;
			}
		});
		//edit list task
		$("#wpcfg_edit").click(function(e) {
			e.preventDefault();
			var l = parseInt($('.wpcfg_row_ch:checked').length);
			if(l > 0) {
				var id = $('.wpcfg_row_ch:checked').first().val();
				var url_part1 =$("#wpcfg_form").attr("action");
				var url = url_part1 + '&act=edit&id=' + id;
				window.location.replace(url);
				return false;
			}
			else {
				alert('Please first make a selection from the list');
				return false;
			}
		});
		//delete task
		$("#wpcfg_delete").click(function(e) {
			e.preventDefault();
			var l = parseInt($('.wpcfg_row_ch:checked').length);
			if(l > 0) {
				if(confirm('Delete selected items?')) {
					$("#wpcfg_task").val('delete');
					$("#wpcfg_form").submit();
				}
				return false;
			}
			else {
				alert('Please first make a selection from the list');
				return false;
			}
		});
		
		
		//filter select
		$(".wpcfg_select").change(function() {
			$("#wpcfg_form").submit();
		});
		//filter search
		$("#wpcfg_filter_search_submit").click(function() {
			$("#wpcfg_form").submit();
		});
		
		//list of checkbox
		$('.wpcfg_row_ch').click(function() {
			if(!($(this).is(':checked'))) {
				$("#wpcfg_check_all").attr('checked',false);
			}
			wpcfg_check_the_selection();
		});
		
		function wpcfg_check_the_selection() {
			var l = parseInt($('.wpcfg_row_ch:checked').length);
			if(l == 0) {
				$('.wpcfg_disabled').addClass('button-disabled');
				$('.wpcfg_disabled').attr('title','Please make a selection from the list, to activate this button');
			}
			else {
				$('.wpcfg_disabled').removeClass('button-disabled');
				$('.wpcfg_disabled').attr('title','');
			}
		};
		
		/////////////////////////////////////////////////////Add form//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$("#wpcfg_form_save").click(function() {
			if(!wpcfg_validate_form())
				return false;
			$("#wpcfg_task").val('save');
			$("#wpcfg_form").submit();
			return false;
		});
		$("#wpcfg_form_save_close").click(function() {
			if(!wpcfg_validate_form())
				return false;
			$("#wpcfg_task").val('save_close');
			$("#wpcfg_form").submit();
			return false;
		});
		$("#wpcfg_form_save_new").click(function() {
			if(!wpcfg_validate_form())
				return false;
			$("#wpcfg_task").val('save_new');
			$("#wpcfg_form").submit();
			return false;
		});
		$("#wpcfg_form_save_copy").click(function() {
			alert('Please upgrade to PRO version to use this option!');
			return false;
		});
		
		//function to validate forms form
		function wpcfg_validate_form() {
			var tested = true;
			$("#wpcfg_form").find('.required').each(function() {
				var val = $.trim($(this).val());
				if(val == '') {
					$(this).addClass('wpcfg_error');
					tested = false;
				}
				else
					$(this).removeClass('wpcfg_error');
			});
			if(tested)
				return true;
			else
				return false;
		};
		
		//////////////////////////////////////////////////Table list sortable///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var wpcfg_selected_tr_id = 0;
		function wpcfg_make_sortable() {
			var table_name = $("#wpcfg_sortable").attr("table_name");
			var reorder_type = $("#wpcfg_sortable").attr("reorder_type");

			// 2.5.0 fix
			var cfg_token = $("#cfg_token").val();

			if(!$("#wpcfg_sortable").length)
				return;
			
			//sortable
			$("#wpcfg_sortable").sortable();
			$("#wpcfg_sortable").disableSelection();
			$("#wpcfg_sortable").sortable( "option", "disabled", true );
			$("#wpcfg_sortable .wpcfg_reorder").mousedown(function()
			{
				wpcfg_selected_tr_id = $(this).parents('tr').attr("id");
				$( "#wpcfg_sortable" ).sortable( "option", "disabled", false );
			});
			$( "#wpcfg_sortable" ).sortable(
			{
				update: function(event, ui) 
				{
					var order = $("#wpcfg_sortable").sortable('toArray').toString();
					$.post
					(
							"admin.php?page=cfg_forms&act=cfg_submit_data&holder=cfg_ajax",
							{order: order,type: reorder_type,table_name: table_name,cfg_token: cfg_token},
							function(data)
							{
								//window.location.reload();
								return false;
							}
					);
				}
			});
			$( "#wpcfg_sortable" ).sortable(
			{
				stop: function(event, ui) 
				{
					$( "#wpcfg_sortable" ).sortable( "option", "disabled", true );
				}
			});
		}
		wpcfg_make_sortable();
		
		function wpcfg_generate_td_width() {
			$('.ui-state-default').each(function() {
				$(this).find('td').each(function(i) {
					if(i == $(this).find('td').length)
						var w = $(this).width()-2;
					else
						var w = $(this).width();
					$(this).attr("w",w);
					$(this).css('width',w);
				});
			})
		};
		wpcfg_generate_td_width();
		
		//field type limit
		var cfg_type_id = parseInt($("#wpcfg_id_type").val());
		$("#wpcfg_id_type").change(function() {
			var id = $(this).val();
			if(id == 13 || id == 14 || id == 15 || id == 16 || id == 17 || id == 18 || id == 19 || id == 20 || id == 21) {
				alert('Please Upgrade to PRO Version to use this field type');
				$(this).val(cfg_type_id);
				return false;
			}
			cfg_type_id = id;
		});
		$("#wpcfg_column_type").change(function() {
			var id = $(this).val();
			if(id == 1 || id == 2) {
				alert('Please Upgrade to PRO Version to use this option');
				$(this).val(0);
				return false;
			}
		});

		//check/uncheck all
		// $("#wpcfg_close_rate_us_dialog").click(function() {
		// 		$(".wpcfg_rate_us_wrapper").hide();
		// 		$.post
		// 			(
		// 					"admin.php?page=cfg_forms&act=cfg_submit_data&holder=cfg_ajax",
		// 					{type: 'hide_rate_us'},
		// 					function(data)
		// 					{
		// 						return false;
		// 					}
		// 			);
		// });
	};

	this.runFunctions = function() {

        this.applyAdminFunction();

        this.applyCookies();

        this.detectState();

        this.applyNewFunctions();
    };

    this.detectState = function() {

    	var wpcfg_rate_hidden = thisPage.getCookie('wpcfg_rate_hidden');
    	var wpcfg_other_plg_hidden = thisPage.getCookie('wpcfg_other_plg_hidden');

    	// detect rate us wrp state
    	if(wpcfg_rate_hidden == 1) {
    		$(".wpcfg_rate_us_wrapper").addClass('wpcfg_hidden').removeClass("wpcfg_visible");
    	}
    	else {
    		$(".wpcfg_rate_us_wrapper").removeClass('wpcfg_hidden').addClass("wpcfg_visible");
    	}

    	// detect state for other plugins
    	if(wpcfg_other_plg_hidden == 1) {
    		$(".wpcfg_other_plg_state_visible").addClass('wpcfg_hidden').removeClass("wpcfg_visible");
    		$(".wpcfg_other_plg_state_hidden").removeClass('wpcfg_hidden').addClass("wpcfg_visible");
    		$(".wpcfg_other_plg_wrp").addClass('wpcfg_hidden').removeClass("wpcfg_visible");
    	}
    	else {
    		$(".wpcfg_other_plg_state_visible").removeClass('wpcfg_hidden').addClass("wpcfg_visible");
    		$(".wpcfg_other_plg_state_hidden").addClass('wpcfg_hidden').removeClass("wpcfg_visible");
    		$(".wpcfg_other_plg_wrp").removeClass('wpcfg_hidden').addClass("wpcfg_visible");
    	}

    };

    this.applyNewFunctions = function() {

    	// hide rate us
    	$("#wpcfg_close_rate_us_dialog").click(function() {

    		$(".wpcfg_rate_us_wrapper").addClass('wpcfg_hidden').removeClass("wpcfg_visible");

    		thisPage.eraseCookie('wpcfg_rate_hidden');
            thisPage.setCookie('wpcfg_rate_hidden','1',-1);

    	});

    	// toggle other plugins
    	$(".wpcfg_other_plg_state_visible").click(function() {

    		$(".wpcfg_other_plg_wrp").addClass('wpcfg_hidden').removeClass("wpcfg_visible");
    		$(".wpcfg_other_plg_state_visible").addClass('wpcfg_hidden').removeClass("wpcfg_visible");
    		$(".wpcfg_other_plg_state_hidden").removeClass('wpcfg_hidden').addClass("wpcfg_visible");

    		thisPage.eraseCookie('wpcfg_other_plg_hidden');
            thisPage.setCookie('wpcfg_other_plg_hidden','1',-1);

    	});

    	$(".wpcfg_other_plg_state_hidden").click(function() {

    		$(".wpcfg_other_plg_wrp").removeClass('wpcfg_hidden').addClass("wpcfg_visible");
    		$(".wpcfg_other_plg_state_visible").removeClass('wpcfg_hidden').addClass("wpcfg_visible");
    		$(".wpcfg_other_plg_state_hidden").addClass('wpcfg_hidden').removeClass("wpcfg_visible");

    		thisPage.eraseCookie('wpcfg_other_plg_hidden');
    	});

    };

    this.init = function() {

        this.initVars();

        this.runFunctions();
    };

    this.applyCookies = function() {

        this.setCookie = function(key, value, expiry) {

            var cookie_val = key + '=' + value + ';path=/';
            if(expiry != -1) {
                var expires = new Date();
                expires.setTime(expires.getTime() + (expiry * 60 * 60 * 1000)); // in hours
                cookie_val += ';expires=' + expires.toUTCString();
            }
            document.cookie = cookie_val;
        };

        this.getCookie = function(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        };

        this.eraseCookie = function(key) {
            var keyValue = this.getCookie(key);
            this.setCookie(key, keyValue, '-2');
        };
    };

	this.init();
};
	
					
$(document).ready(function() {
    
    // cfg 2.7 and higher
    var cfg_options = {};
    window.cfghDash = new cfgDash(cfg_options);
                    
});
})(jQuery);