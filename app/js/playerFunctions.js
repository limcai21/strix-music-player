// DECLARE AUDIO
window.audio = new Audio();

$(document).ready(function () {

    // GENERAL DEFINE
    var musicIsPlaying = false;
    var progressBarMouseUp = true;
    window.shuffleState = false;
    var currentSongID = 0;
    var repeatCounter = 0;
    var favouriteCounter = 0;

    // SVG 
    const playSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>';
    const pauseSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5.746 3a1.75 1.75 0 0 0-1.75 1.75v14.5c0 .966.784 1.75 1.75 1.75h3.5a1.75 1.75 0 0 0 1.75-1.75V4.75A1.75 1.75 0 0 0 9.246 3h-3.5ZM14.746 3a1.75 1.75 0 0 0-1.75 1.75v14.5c0 .966.784 1.75 1.75 1.75h3.5a1.75 1.75 0 0 0 1.75-1.75V4.75A1.75 1.75 0 0 0 18.246 3h-3.5Z" fill="#fff"/></svg>';
    const volumeMute = '<svg width="16" height="16" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M15 4.25c0-1.079-1.274-1.65-2.08-.934L8.427 7.309a.75.75 0 0 1-.498.19H4.25A2.25 2.25 0 0 0 2 9.749v4.497a2.25 2.25 0 0 0 2.25 2.25h3.68a.75.75 0 0 1 .498.19l4.491 3.994c.806.716 2.081.144 2.081-.934V4.25ZM16.22 9.22a.75.75 0 0 1 1.06 0L19 10.94l1.72-1.72a.75.75 0 1 1 1.06 1.06L20.06 12l1.72 1.72a.75.75 0 1 1-1.06 1.06L19 13.06l-1.72 1.72a.75.75 0 1 1-1.06-1.06L17.94 12l-1.72-1.72a.75.75 0 0 1 0-1.06Z" fill="#fff"/></svg>'
    const volumeLow = '<svg width="16" height="16" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M14.704 3.441c.191.226.296.512.296.808V19.75a1.25 1.25 0 0 1-2.058.954l-4.967-4.206H4.25A2.25 2.25 0 0 1 2 14.248v-4.5a2.25 2.25 0 0 1 2.25-2.25h3.725l4.968-4.204a1.25 1.25 0 0 1 1.761.147Z" fill="#fff"/></svg>'
    const volumeMedium = '<svg width="16" height="16" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M14.704 3.442c.191.226.296.512.296.808v15.502a1.25 1.25 0 0 1-2.058.954L7.975 16.5H4.25A2.25 2.25 0 0 1 2 14.25v-4.5A2.25 2.25 0 0 1 4.25 7.5h3.725l4.968-4.204a1.25 1.25 0 0 1 1.761.147Zm2.4 5.198a.75.75 0 0 1 1.03.25c.574.94.862 1.992.862 3.14 0 1.149-.288 2.201-.862 3.141a.75.75 0 1 1-1.28-.781c.428-.702.642-1.483.642-2.36 0-.876-.214-1.657-.642-2.359a.75.75 0 0 1 .25-1.03Z" fill="#fff"/></svg>'
    const volumeHigh = '<svg width="16" height="16" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M15 4.25v15.496c0 1.078-1.274 1.65-2.08.934l-4.492-3.994a.75.75 0 0 0-.498-.19H4.25A2.25 2.25 0 0 1 2 14.247V9.75a2.25 2.25 0 0 1 2.25-2.25h3.68a.75.75 0 0 0 .498-.19l4.491-3.993C13.726 2.599 15 3.17 15 4.25Zm3.992 1.647a.75.75 0 0 1 1.049.157A9.959 9.959 0 0 1 22 12a9.96 9.96 0 0 1-1.96 5.946.75.75 0 0 1-1.205-.892A8.459 8.459 0 0 0 20.5 12a8.459 8.459 0 0 0-1.665-5.054.75.75 0 0 1 .157-1.049ZM17.143 8.37a.75.75 0 0 1 1.017.303c.536.99.84 2.125.84 3.328a6.973 6.973 0 0 1-.84 3.328.75.75 0 0 1-1.32-.714c.42-.777.66-1.666.66-2.614s-.24-1.837-.66-2.614a.75.75 0 0 1 .303-1.017Z" fill="#fff"/></svg>'
    const repeatOff = '<svg height="100%" viewBox="0 0 1024 1024" width="100%" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M1024,992C1024,1000.67 1020.83,1008.17 1014.5,1014.5C1008.17,1020.83 1000.67,1024 992,1024C983.333,1024 975.833,1020.83 969.5,1014.5L9.5,54.5C3.16667,48.1667 0,40.6667 0,32C0,23.3334 3.16667,15.8334 9.5,9.5C15.8333,3.16669 23.3333,0 32,0C40.6667,0 48.1667,3.16669 54.5,9.5L1014.5,969.5C1020.83,975.833 1024,983.333 1024,992ZM384,192C375.333,192 366.667,192.333 358,193C349.333,193.667 340.667,194.667 332,196L278.5,143C312.5,133 347.667,128 384,128L723,128L649.5,54.5C643.167,48.1667 640,40.6667 640,32C640,23.3334 643.167,15.8334 649.5,9.5C655.833,3.16669 663.333,0 672,0C680.667,0 688.167,3.16669 694.5,9.5L822.5,137.5C828.833,143.833 832,151.333 832,160C832,168.667 828.833,176.167 822.5,182.5L694.5,310.5C688.167,316.833 680.667,320 672,320C663.333,320 655.833,316.833 649.5,310.5C643.167,304.167 640,296.667 640,288C640,279.333 643.167,271.833 649.5,265.5L723,192ZM157,202.5L203,248C181,262.667 161.417,279.75 144.25,299.25C127.083,318.75 112.583,339.833 100.75,362.5C88.9167,385.167 79.8333,409.167 73.5,434.5C67.1667,459.833 64,485.667 64,512C64,548.333 69.4167,581.833 80.25,612.5C91.0833,643.167 106.667,673.333 127,703C129.333,706.333 131,709.25 132,711.75C133,714.25 133.5,717.667 133.5,722C133.5,730.667 130.333,738.25 124,744.75C117.667,751.25 110.167,754.5 101.5,754.5C95.8333,754.5 91.0833,753.333 87.25,751C83.4167,748.667 79.6667,745.5 76,741.5C71.6667,736.833 67.75,731.5 64.25,725.5C60.75,719.5 57.3333,713.833 54,708.5C36,678.5 22.5,646.917 13.5,613.75C4.5,580.583 0,546.667 0,512C0,449 13.75,391.083 41.25,338.25C68.75,285.417 107.333,240.167 157,202.5ZM870,734.5C898.667,704.5 920.833,670.333 936.5,632C952.167,593.667 960,553.667 960,512C960,475.667 954.583,442.167 943.75,411.5C932.917,380.833 917.333,350.667 897,321C894.667,317.667 893,314.75 892,312.25C891,309.75 890.5,306.333 890.5,302C890.5,293.333 893.667,285.75 900,279.25C906.333,272.75 913.833,269.5 922.5,269.5C928.167,269.5 932.917,270.667 936.75,273C940.583,275.333 944.333,278.5 948,282.5C951.667,286.833 955.167,291.583 958.5,296.75C961.833,301.917 965,307 968,312C986.333,342.333 1000.25,374.417 1009.75,408.25C1019.25,442.083 1024,476.667 1024,512C1024,562 1014.67,610.083 996,656.25C977.333,702.417 950.5,743.5 915.5,779.5ZM301.5,832L640,832C682,832 722.833,823.833 762.5,807.5L810.5,856C783.833,869 756.25,878.917 727.75,885.75C699.25,892.583 670,896 640,896L301.5,896L374.5,969.5C380.833,975.833 384,983.333 384,992C384,1000.67 380.833,1008.17 374.5,1014.5C368.167,1020.83 360.667,1024 352,1024C343.333,1024 335.833,1020.83 329.5,1014.5L201.5,886.5C195.167,880.167 192,872.667 192,864C192,855.333 195.167,847.833 201.5,841.5L329.5,713.5C335.833,707.167 343.333,704 352,704C360.667,704 368.167,707.167 374.5,713.5C380.833,719.833 384,727.333 384,736C384,744.667 380.833,752.167 374.5,758.5Z" fill="#FFFFFF" fill-opacity="1"></path></svg>';
    const repeatOne = '<svg height="100%" viewBox="0 0 1024 1024" width="100%" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M384,192C339.667,192 298.083,200.333 259.25,217C220.417,233.667 186.5,256.5 157.5,285.5C128.5,314.5 105.667,348.417 89,387.25C72.3333,426.083 64,467.667 64,512C64,531.667 65.4167,549.583 68.25,565.75C71.0833,581.917 75.1667,597.5 80.5,612.5C85.8333,627.5 92.5,642.25 100.5,656.75C108.5,671.25 117.5,686.667 127.5,703C129.5,706.333 131.083,709.417 132.25,712.25C133.417,715.083 134,718.333 134,722C134,730.667 130.75,738.167 124.25,744.5C117.75,750.833 110.167,754 101.5,754C95.8333,754 91.0833,752.833 87.25,750.5C83.4167,748.167 79.6667,745 76,741C64,727 53.25,710.667 43.75,692C34.25,673.333 26.25,653.667 19.75,633C13.25,612.333 8.33333,591.5 5,570.5C1.66667,549.5 0,530 0,512C0,460.333 9.66667,411.25 29,364.75C48.3333,318.25 76.1667,276.833 112.5,240.5C148.833,204.167 190.25,176.333 236.75,157C283.25,137.667 332.333,128 384,128L723,128L649.5,54.5C643.167,48.1667 640,40.6667 640,32C640,23.3334 643.167,15.8334 649.5,9.5C655.833,3.16669 663.333,0 672,0C680.667,0 688.167,3.16669 694.5,9.5L822.5,137.5C828.833,143.833 832,151.333 832,160C832,168.667 828.833,176.167 822.5,182.5L694.5,310.5C688.167,316.833 680.667,320 672,320C663.333,320 655.833,316.833 649.5,310.5C643.167,304.167 640,296.667 640,288C640,279.333 643.167,271.833 649.5,265.5L723,192ZM890.5,302C890.5,293.333 893.583,285.75 899.75,279.25C905.917,272.75 913.5,269.5 922.5,269.5C928.167,269.5 932.917,270.667 936.75,273C940.583,275.333 944.333,278.5 948,282.5C960,296.167 970.667,312.167 980,330.5C989.333,348.833 997.167,368.083 1003.5,388.25C1009.83,408.417 1014.75,428.75 1018.25,449.25C1021.75,469.75 1023.67,489 1024,507C1013.33,494 1002,481.583 990,469.75C978,457.917 965.167,447.167 951.5,437.5C946.167,415.5 938.75,395.333 929.25,377C919.75,358.667 909,340 897,321C894.667,317.333 893,314.333 892,312C891,309.667 890.5,306.333 890.5,302ZM1024,736C1024,775.667 1016.42,813 1001.25,848C986.083,883 965.5,913.5 939.5,939.5C913.5,965.5 883,986.083 848,1001.25C813,1016.42 775.667,1024 736,1024C696,1024 658.5,1016.5 623.5,1001.5C588.5,986.5 558,966 532,940C506,914 485.5,883.5 470.5,848.5C455.5,813.5 448,776 448,736C448,696.333 455.583,659 470.75,624C485.917,589 506.5,558.5 532.5,532.5C558.5,506.5 589,485.917 624,470.75C659,455.583 696.333,448 736,448C762.333,448 787.75,451.417 812.25,458.25C836.75,465.083 859.667,474.75 881,487.25C902.333,499.75 921.833,514.833 939.5,532.5C957.167,550.167 972.25,569.667 984.75,591C997.25,612.333 1006.92,635.25 1013.75,659.75C1020.58,684.25 1024,709.667 1024,736ZM768,608C768,599.333 764.833,591.833 758.5,585.5C752.167,579.167 744.667,576 736,576C727.333,576 719.833,579.167 713.5,585.5L649.5,649.5C643.167,655.833 640,663.333 640,672C640,680.667 643.167,688.167 649.5,694.5C655.833,700.833 663.333,704 672,704C679.333,704 685.333,702.083 690,698.25C694.667,694.417 699.333,690.167 704,685.5L704,864C704,872.667 707.167,880.167 713.5,886.5C719.833,892.833 727.333,896 736,896C744.667,896 752.167,892.833 758.5,886.5C764.833,880.167 768,872.667 768,864ZM380.5,832C386.5,854.333 394.5,875.667 404.5,896L301.5,896L374.5,969.5C380.833,975.833 384,983.333 384,992C384,1000.67 380.833,1008.17 374.5,1014.5C368.167,1020.83 360.667,1024 352,1024C343.333,1024 335.833,1020.83 329.5,1014.5L201.5,886.5C195.167,880.167 192,872.667 192,864C192,855.333 195.167,847.833 201.5,841.5L329.5,713.5C335.833,707.167 343.333,704 352,704C358.667,704 364.333,705.667 369,709C368.667,713.667 368.417,718.25 368.25,722.75C368.083,727.25 368,731.833 368,736.5C368,741.167 368.083,745.75 368.25,750.25C368.417,754.75 368.667,759.333 369,764L301.5,832Z" fill="#FFFFFF" fill-opacity="1"></path></svg>';
    const repeatAll = '<svg height="100%" viewBox="0 0 1024 1024" width="100%" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M384,192C339.667,192 298.083,200.333 259.25,217C220.417,233.667 186.5,256.5 157.5,285.5C128.5,314.5 105.667,348.417 89,387.25C72.3333,426.083 64,467.667 64,512C64,539 67.5,566.083 74.5,593.25C81.5,620.417 91.8333,645.833 105.5,669.5C107.5,673.167 110.083,677.167 113.25,681.5C116.417,685.833 119.5,690.333 122.5,695C125.5,699.667 128.083,704.333 130.25,709C132.417,713.667 133.5,718 133.5,722C133.5,730.667 130.333,738.167 124,744.5C117.667,750.833 110.167,754 101.5,754C95.8333,754 91.0833,752.833 87.25,750.5C83.4167,748.167 79.6667,745 76,741C63.6667,726.667 52.75,710.167 43.25,691.5C33.75,672.833 25.8333,653.333 19.5,633C13.1667,612.667 8.33333,592.083 5,571.25C1.66667,550.417 0,530.667 0,512C0,477 4.58333,443.167 13.75,410.5C22.9167,377.833 35.8333,347.25 52.5,318.75C69.1667,290.25 89.1667,264.333 112.5,241C135.833,217.667 161.667,197.583 190,180.75C218.333,163.917 248.917,150.917 281.75,141.75C314.583,132.583 348.667,128 384,128L723,128L649.5,54.5C643.167,48.1667 640,40.6667 640,32C640,23.3334 643.167,15.8334 649.5,9.5C655.833,3.16669 663.333,0 672,0C680.667,0 688.167,3.16669 694.5,9.5L822.5,137.5C828.833,143.833 832,151.333 832,160C832,168.667 828.833,176.167 822.5,182.5L694.5,310.5C688.167,316.833 680.667,320 672,320C663.333,320 655.833,316.833 649.5,310.5C643.167,304.167 640,296.667 640,288C640,279.333 643.167,271.833 649.5,265.5L723,192ZM1024,512C1024,547.333 1019.42,581.25 1010.25,613.75C1001.08,646.25 988.167,676.75 971.5,705.25C954.833,733.75 934.833,759.667 911.5,783C888.167,806.333 862.333,826.417 834,843.25C805.667,860.083 775.083,873.083 742.25,882.25C709.417,891.417 675.333,896 640,896L301.5,896L374.5,969.5C380.833,975.833 384,983.333 384,992C384,1000.67 380.833,1008.17 374.5,1014.5C368.167,1020.83 360.667,1024 352,1024C343.333,1024 335.833,1020.83 329.5,1014.5L201.5,886.5C195.167,880.167 192,872.667 192,864C192,855.333 195.167,847.833 201.5,841.5L329.5,713.5C335.833,707.167 343.333,704 352,704C360.667,704 368.167,707.167 374.5,713.5C380.833,719.833 384,727.333 384,736C384,744.667 380.833,752.167 374.5,758.5L301.5,832L640,832C684.333,832 725.917,823.667 764.75,807C803.583,790.333 837.5,767.5 866.5,738.5C895.5,709.5 918.333,675.583 935,636.75C951.667,597.917 960,556.333 960,512C960,493 958.667,475.333 956,459C953.333,442.667 949.333,426.833 944,411.5C938.667,396.167 932.083,381.167 924.25,366.5C916.417,351.833 907.333,336.667 897,321C894.667,317.333 893,314.333 892,312C891,309.667 890.5,306.333 890.5,302C890.5,293.333 893.583,285.75 899.75,279.25C905.917,272.75 913.5,269.5 922.5,269.5C928.167,269.5 932.917,270.667 936.75,273C940.583,275.333 944.333,278.5 948,282.5C960.333,296.833 971.25,313.333 980.75,332C990.25,350.667 998.167,370.25 1004.5,390.75C1010.83,411.25 1015.67,431.917 1019,452.75C1022.33,473.583 1024,493.333 1024,512Z" fill="#FFFFFF" fill-opacity="1"></path></svg>'
    const explicitSVG = '<svg class="explicitIcon" width="24" height="24" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg" class="glyph" aria-hidden="true"><path d="M1.59 8.991h5.82c1.043 0 1.582-.538 1.582-1.566v-5.85C8.992.547 8.453.008 7.41.008H1.59C.552.008.008.542.008 1.575v5.85c0 1.028.544 1.566 1.582 1.566zm1.812-2.273c-.332 0-.505-.211-.505-.553V2.753c0-.341.173-.553.505-.553h2.264c.245 0 .408.14.408.385 0 .235-.163.384-.408.384H3.854v1.106h1.71c.226 0 .38.125.38.355 0 .221-.154.346-.38.346h-1.71V5.95h1.812c.245 0 .408.14.408.385 0 .235-.163.384-.408.384H3.402z"></path></svg>';
    const favouriteSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12.82 5.58-.82.822-.824-.824a5.375 5.375 0 1 0-7.601 7.602l7.895 7.895a.75.75 0 0 0 1.06 0l7.902-7.897a5.376 5.376 0 0 0-.001-7.599 5.38 5.38 0 0 0-7.611 0Zm6.548 6.54L12 19.485 4.635 12.12a3.875 3.875 0 1 1 5.48-5.48l1.358 1.357a.75.75 0 0 0 1.073-.012L13.88 6.64a3.88 3.88 0 0 1 5.487 5.48Z" fill="#fff"/></svg>';
    const favouriteSVGFilled = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12.82 5.58-.82.822-.824-.824a5.375 5.375 0 1 0-7.601 7.602l7.895 7.895a.75.75 0 0 0 1.06 0l7.902-7.897a5.376 5.376 0 0 0-.001-7.599 5.38 5.38 0 0 0-7.611 0Z" fill="#fff"/></svg>';


    // COMPONENT DEFINE 
    var playPauseBtn = $("#playPauseBtn")
    var nextBtn = $("#nextBtn")
    var previousBtn = $("#previousBtn")
    var shuffleBtn = $("#shuffleBtn")
    var repeatBtn = $("#repeatBtn")
    var volumeControl = $("#volumeControl")
    var songCard = document.getElementsByClassName("songCard")
    var progressBar = $("#progressBar")
    var favouriteBtn = $("#favouriteBtn")






    function disablePlayerBtn() {
        progressBar.attr("disabled", "")
        shuffleBtn.attr("disabled", "")
        nextBtn.attr("disabled", "")
        previousBtn.attr("disabled", "")
        playPauseBtn.attr("disabled", "")
        repeatBtn.attr("disabled", "")
        $("#favouriteBtn").attr("disabled", "")
        $("#viewQueueBtn").attr("disabled", "")
        $(".progressSection").css("display", "none")
        $("#playerAlbumArt").css("width", "0px").css("height", "50px").css("min-width", "unset");;
        $(".songInfo .songData .songNameAndArtist .title").text("No music playing")
        $(".songInfo .songData .songNameAndArtist .artist").css("display", "none")
    }

    function enablePlayerBtn() {
        shuffleBtn.removeAttr("disabled")
        nextBtn.removeAttr("disabled")
        previousBtn.removeAttr("disabled")
        playPauseBtn.removeAttr("disabled")
        repeatBtn.removeAttr("disabled")
        $("#favouriteBtn").removeAttr("disabled")
        $(".progressSection").css("display", "flex")
        $(".mediaPlayer .left").css("visibility", "visible")
        $(".progressSection").css("display", "flex")
        $(".mediaSection").css("display", "flex")
        $(".volumeSection").css("display", "flex")
        $(".otherIcons").css("display", "flex")
        $("#playerAlbumArt").css("min-width", "50px")
        $(".songInfo .songData .songNameAndArtist .artist").css("display", "block")
    }







    window.changeSong = function(songID) {
        audio.pause();

        if (songID == undefined) {
            getSongInfo(userPlaylist[0])
            musicIsPlaying = true;
        }

        else {
            getSongInfo(songID);
            musicIsPlaying = false;
        }
    }


    // CHANGE PAGE TITLE 
    function changePageTitle(title) {
        document.title = title;
    }


    function getSongInfo(songID) {
        $.ajax({
            type: 'get',
            dataType: 'JSON',
            url: "./process/getSongInfo.php?songID=" + songID, 
            success: function(result){

                const songTitle = result[0].songTitle;
                const songArtist = result[0].songArtist;
                const songExplicit = result[0].songExplicit;
                const albumCover = result[0].albumCover;
                const songURL = result[0].songURL;
                const albumTitle = result[0].albumTitle;


                audio.src = songURL
                audio.load();


                $(".mediaPlayer").addClass("backgroundBlur")
                $("#playerAlbumArt").attr("src", albumCover)
                $(".songNameAndArtist .artist").html(songArtist)
                $(".mediaPlayerMainDiv").css("background-image", "url('" + albumCover + "')")

                if (songExplicit == 1) {
                    $(".songNameAndArtist .title").html(songTitle + explicitSVG)
                }

                else {
                    $(".songNameAndArtist .title").html(songTitle);
                }




                // CHECK IF SONG IS FAV (FOR PLAYER FAVOURITE BTN)
                $.ajax({
                    type: 'get',
                    dataType: 'JSON',
                    url: "./process/checkIfSongIsFavourite.php?songID=" + songID, 
                    success: function(result){
                        $status = result[0].status
                        $status1 = result[0].status1         
                        $svg1 = result[0].svg1
        
                        if (!$status) {
                            if ($status1) {
                                $("#favouriteBtn").html($svg1);
                                $("#favouriteBtn").attr("favourite", "1")
                            }
        
                            else {
                                $("#favouriteBtn").html($svg1);
                                $("#favouriteBtn").attr("favourite", "0")
                            }
        
                            $("#favouriteBtn").attr("songid", songID);




                            // Media Session API
                            if ('mediaSession' in navigator) {
                                navigator.mediaSession.metadata = new MediaMetadata({
                                    title: songTitle,
                                    artist: songArtist,
                                    album: albumTitle,
                                    artwork: [
                                        { src: albumCover }
                                    ]
                                })

                                navigator.mediaSession.setActionHandler('play', function() { playAudio() });
                                navigator.mediaSession.setActionHandler('pause', function() { playAudio() });
                                navigator.mediaSession.setActionHandler('previoustrack', function() { previous() });
                                navigator.mediaSession.setActionHandler('nexttrack', function() { next() });
                            }
                            
                            changePageTitle(songTitle + " • " + songArtist)
                            currentSongID = songID;
                            playAudio();

                            if (musicIsPlaying == true) {
                                $(".progressSection").css("display", "none");
                            }
                        }
        
                        else {
                            alert("Something went wrong, try again later")
                        }
                    }
                });
                

            }
        });
    }
    
    function playAudio() {
        if (audio.src != "") {
            var playPromise = audio.play();
            enablePlayerBtn();
            repeatChecker();

            
            // FIX ASYNC PROBLEM
            if (playPromise !== undefined) {
                // Show playing UI.
                playPromise.then(_ => {
                    if (musicIsPlaying) {
                        playPauseBtn.html(playSVG)
                        playPauseBtn.attr("title", "Play")
                        musicIsPlaying = false;
                        audio.pause();
                        changePageTitle("Strix - Web Player");
                    }

                    else {
                        playPauseBtn.html(pauseSVG)
                        playPauseBtn.attr("title", "Pause")
                        musicIsPlaying = true;
                        audio.play();
                        
                        const title = $(".songInfo .songData .songNameAndArtist .title").text();
                        const artist = $(".songInfo .songData .songNameAndArtist .artist").text();
                        changePageTitle(title + " • " + artist);
                    }
                })

                .catch(error => {
                    // Auto-play was prevented
                    // Show paused UI.
                    playPauseBtn.html(playSVG)
                    playPauseBtn.attr("title", "Play")
                    musicIsPlaying = false;
                    audio.pause();
                    changePageTitle("Strix - Web Player");
                });
            }
        }

        else {
            disablePlayerBtn();
        }
    }

    function changeVolume() {
        inputVolume = volumeControl.val()
        audio.volume = inputVolume / 100;

    
        if (inputVolume != 0) {
            if (inputVolume > 0 && inputVolume < 33.33) {
                volumeSVG = volumeLow
            }

            else if (inputVolume > 33.33 && inputVolume < 66.66) {
                volumeSVG = volumeMedium
            }

            else {
                volumeSVG = volumeHigh
            }
        }

        else {
            volumeSVG = volumeMute
        }
        
        $("#volumeIcon").html(volumeSVG);
        $("#volumeIcon").css("color", 'white')
    }

    function next() {
        audio.pause();

        for (var i = 0; i < userPlaylist.length; i++) {
            if (userPlaylist[i] == currentSongID) {
                if ((currentSongID == userPlaylist[userPlaylist.length - 1]) && (repeatCounter == 1)) {
                    changeSong(userPlaylist[0]);     
                }

                else {
                    if (repeatCounter == 2) {
                        musicIsPlaying = false
                        audio.currentTime = 0;
                        playAudio();
                    }
                    else {
                        const nextSongID = userPlaylist[i + 1];
                        changeSong(nextSongID);     
                    }
                }
            }
        }
    }

    function previous() {
        var sec = new Number();
        sec = Math.floor( audio.currentTime );    
        sec = Math.floor( sec % 60 );
        sec = sec >= 10 ? sec : '0' + sec;

        if (sec > 5) {
            audio.currentTime = 0
        }

        else {
            audio.pause();

            if (repeatCounter == 0) {
                if (currentSongID == userPlaylist[0]) {
                    audio.currentTime = 0;
                    musicIsPlaying = true;
                    playAudio();
                }

                else {
                    for (var i = 0; i < userPlaylist.length; i++) {
                        if (currentSongID == userPlaylist[i]) {
                            changeSong(userPlaylist[i - 1]);
                        }
                    }
                }
            }

            else {
                if (repeatCounter == 1) {
                    if (currentSongID == userPlaylist[0]) {
                        changeSong(userPlaylist[userPlaylist.length - 1]);
                    }

                    else {
                        for (var i = 0; i < userPlaylist.length; i++) {
                            if (currentSongID == userPlaylist[i]) {
                                changeSong(userPlaylist[i - 1]);
                            }
                        }
                    }
                }

                if (repeatCounter == 2) {
                    audio.currentTime = 0;
                    musicIsPlaying = false;
                    playAudio();
                }
            }
        }
    }

    function repeat() {
        repeatCounter++

        if ((repeatCounter % 3) == 1) {
            // Repeat All
            repeatBtn.html(repeatAll)
            repeatBtn.attr("title", "Repeat All")
            repeatBtn.addClass("activeBtn")
            audio.loop = false;
        }

        else if ((repeatCounter % 3) == 2) {
            // Repeat One
            repeatBtn.html(repeatOne)
            repeatBtn.attr("title", "Repeat One")
            repeatBtn.addClass("activeBtn")
            audio.loop = true;
        }

        else if ((repeatCounter % 3) == 0) {
            // Repeat Off
            repeatBtn.html(repeatOff)
            repeatBtn.attr("title", "Repeat Off")
            repeatBtn.removeClass("activeBtn")
            repeatCounter = 0;
            audio.loop = false;
        }

        repeatChecker();
    }


    // CHECK AND DISABLE PREVIOUS AND FORWARD BUTTON
    function repeatChecker() {
        var currentSongIndexInPlaylist = userPlaylist.indexOf(currentSongID);
        var userPlaylistLength = userPlaylist.length;

        nextBtn.removeAttr("disabled");
        previousBtn.removeAttr("disabled");

        // No repeat
        if (repeatCounter == 0) {
            if (currentSongIndexInPlaylist == userPlaylistLength - 1) {
                nextBtn.attr("disabled", "");
            }

            if (currentSongIndexInPlaylist == 0) {
                previousBtn.attr("disabled", "");
            }
        }

        // Repeat playlist
        else if (repeatCounter == 1) {
            if (currentSongIndexInPlaylist == userPlaylistLength - 1) {
                nextBtn.removeAttr("disabled");
            }

            if (currentSongIndexInPlaylist == 0) {
                previousBtn.removeAttr("disabled");
            }     
        }
    }




    // SHUFFLE
    function shuffle() {
        if (shuffleState) {
            shuffleState = false
            shuffleBtn.removeClass("hoverBtn");
            shuffleBtn.attr("title", "Shuffle Off")
            
            let oldPlaylist = JSON.parse(localStorage.getItem('oldPlaylist'));
            userPlaylist = oldPlaylist
            console.log("old playlist: " + userPlaylist)
        }

        else {
            localStorage.setItem('oldPlaylist', JSON.stringify(userPlaylist));
            shuffleState = true
            shuffleBtn.addClass("hoverBtn");
            shuffleBtn.attr("title", "Shuffle On")
            shufflePlaylist = userPlaylist.sort(() => Math.random() - 0.5)
            userPlaylist = shufflePlaylist
            console.log("shuffled playlist: " + userPlaylist)
        }

        repeatChecker()
    }



    // SONG TIMING
    function songCurrentTimestamp() {
        if (progressBarMouseUp) {
            var sec = new Number();
            var min = new Number();
            ogSec = Math.floor( audio.currentTime );    
            sec = Math.floor( audio.currentTime );    
            min = Math.floor( sec / 60 );
            min = min >= 10 ? min : '0' + min;    
            sec = Math.floor( sec % 60 );
            sec = sec >= 10 ? sec : '0' + sec;
            currentTimestamp = parseInt(min) + ":" + sec
            
            if (audio.readyState == 4) {
                $("#currentTime").html(currentTimestamp)
                $("#slash").text("/") 
                $("#endTime").css("display", "block");
                progressBar.removeAttr("disabled")
            }

            else {
                progressBar.attr("disabled", "")
                $("#currentTime").text("") 
                $("#slash").text("Loading") 
                $("#endTime").css("display", "none");
            }
            
            
            var sliderPosition = audio.currentTime / audio.duration * 100
            progressBar.val(sliderPosition ? sliderPosition : 0);


            if ((ogSec <= 5) && (repeatCounter == 0) && (userPlaylist[0] == currentSongID)) {
                previousBtn.attr("disabled", "")
            }

            else {
                previousBtn.removeAttr("disabled")
            }
        }


        if (audio.ended) {
            next();
        }
    }

    function songDuration() {
        // GET FROM DATABASE LTR ON

        var sec = new Number();
        var min = new Number();
        sec = Math.floor( audio.duration);    
        min = Math.floor( sec / 60 );
        min = min >= 10 ? min : '0' + min;    
        sec = Math.floor( sec % 60 );
        sec = sec >= 10 ? sec : '0' + sec;
        endTime = parseInt(min) + ":" + sec                

        if (endTime == "0:0NaN") {
            endTime = "0:00"
        }


        $("#endTime").html(endTime)
    }







    // ON CLICK EVENT
    playPauseBtn.click(function (e) { 
        playAudio();
    });

    repeatBtn.click(function (e) { 
        repeat()
    });

    nextBtn.click(function (e) { 
        next()
    });

    previousBtn.click(function (e) { 
        previous()
    });

    volumeControl.change(function (e) { 
        changeVolume();
    })
    
    volumeControl.mousemove(function (e) {
        changeVolume();
    });
    

    progressBar.mousedown(function () { 
        progressBarMouseUp = false
    });

    progressBar.mouseup(function () { 
        progressBarMouseUp = true

        // SET NEW SEEK POSITION
        var newPosition = progressBar.val() / 100;
        audio.currentTime = (audio.duration || 0) * newPosition;
    }).mousemove(function () {
        if (!progressBarMouseUp) {
            var tempPosition = progressBar.val();

            var sec = new Number();
            var min = new Number();
            sec = Math.floor( audio.duration );  
            var tempSeekDuration = Math.floor((sec / 100) * tempPosition)

            sec = new Number();
            min = new Number();
            sec = Math.floor( tempSeekDuration );    
            min = Math.floor( sec / 60 );
            min = min >= 10 ? min : '0' + min;    
            sec = Math.floor( sec % 60 );
            sec = sec >= 10 ? sec : '0' + sec;
            tempSeekDuration = parseInt(min) + ":" + sec

            $("#currentTime").html(tempSeekDuration)
        }
    });


    favouriteBtn.click(function (e) { 
        const songID = $(this).attr("songid");
        const favouriteOrNot = $(this).attr("favourite");
        const element = this;

        $.ajax({
            url: "./process/addToFavourite.php",
            type: 'post',
            data: { songID: songID, favouriteOrNot: favouriteOrNot },
            dataType: 'JSON',
            success: function (result) {
                $status = result[0].status
                $status1 = result[0].status1         // REMOVE FROM FAV
                $svg1 = result[0].svg1
                $status2 = result[0].status2         // ADD TO FAVOURITE
                $svg2 = result[0].svg2

                if ($status) {
                    if ($status1) {
                        $(element).attr("favourite", "0");
                        $(element).html($svg1);
                    }

                    else if ($status2) {
                        $(element).attr("favourite", "1");
                        $(element).html($svg2);
                    }

                    refreshPage();
                }

                else {
                    alert("Something went wrong, try again later")
                }
            }
        })
    });


    shuffleBtn.click(function (e) {
        shuffle();
    })








    // EVENT LISTENER
    audio.addEventListener("timeupdate", songCurrentTimestamp);
    audio.addEventListener("durationchange", songDuration);








    // DISABLE PAGE REFRESH FOR AJAX
    $(document).on("keydown", function(e) {
        if ((e.which || e.keyCode) == 116) e.preventDefault(); 
        if (e.ctrlKey) {
            var c = e.which || e.keyCode;
            if (c == 82) {
                e.preventDefault();
                e.stopPropagation();
            }
        }
    });










    // INIT
    if (audio.src == "") {
        disablePlayerBtn()
    }
});