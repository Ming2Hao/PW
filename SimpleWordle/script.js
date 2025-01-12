$( document ).ready(function(){
  // alert("halo");
  var listkata=["ABUSE", "ADULT", "AGENT", "BASIS", "BEACH", "BIRTH", "CAUSE", "CHAIN", "CHAIR", "DANCE", "DEATH", "DEPTH", "EARTH", "ENEMY", "ENTRY", "FAITH", "FAULT", "FIELD", "GLASS", "GRANT", "GRASS", "HEART", "HENRY", "HORSE", "IMAGE", "INDEX", "INPUT", "JAPAN", "JONES", "JUDGE", "KNIFE", "LAURA", "LAYER", "LEVEL", "MAJOR", "MARCH", "MATCH",  "NIGHT", "NOISE", "NORTH", "OFFER", "ORDER", "OTHER", "PANEL", "PAPER", "PARTY", "QUEEN", "RADIO", "RANGE", "RATIO",  "SCALE", "SCENE", "SCOPE", "TABLE", "TASTE", "TERRY", "UNCLE", "UNION", "UNITY", "VALUE", "VIDEO", "VISIT", "WATCH", "WATER", "WHILE", "YOUTH"];
   var gameover=true;
   var counterbaris=1;
   var counterkotak=1;
   var indexrandom = Math.floor(Math.random() * (listkata.length-1));
   var highscore=[];
  $("#startbtn").click(function(){
    if(gameover==true){
      for (let i = 1; i < 6; i++) {
        for (let j = 1; j < 6; j++) {
          $(`#baris${i} .kotak${j}`).css("border","1px solid rgba(255, 255, 255, 0.5)");
          $(`#baris${i} .kotak${j}`).css("background-color","black");
          $(`#baris${i} .kotak${j}`).text("");
        }
      }
      counterbaris=1;
      counterkotak=1;
      indexrandom = Math.floor(Math.random() * (listkata.length-1));
      gameover=false;
      $(`#baris${counterbaris} .kotak${counterkotak}`).css("border","1px solid white");
      // alert(listkata[indexrandom]);
      $("#startbtn").prop("disabled",true);
      $("#jumlahpemain").prop("disabled",true);
    }
  });


  $("#resetbtn").click(function(){
    if(gameover==false){
      for (let i = 1; i < 6; i++) {
        for (let j = 1; j < 6; j++) {
          $(`#baris${i} .kotak${j}`).css("border","1px solid rgba(255, 255, 255, 0.5)");
          $(`#baris${i} .kotak${j}`).css("background-color","black");
          $(`#baris${i} .kotak${j}`).text("");
        }
      }
      counterbaris=1;
      counterkotak=1;
      indexrandom = Math.floor(Math.random() * (listkata.length-1));
      gameover=true;
      $("#startbtn").prop("disabled",false);
      $("#jumlahpemain").prop("disabled",false);
      $("#jumlahpemain").val("");
      // alert(listkata[indexrandom]);
    }
  });

  $("#cheatbtn").click(function(){
    if(gameover==false){
      alert(listkata[indexrandom]);
    }
  });


  $(document).keypress(function(event){
    if(gameover==false){
      if(event.charCode==13){
        if(counterkotak>=6){
          //penuh
          var jawaban="";
          for (let i = 1; i < 6; i++) {
            jawaban+=$(`#baris${counterbaris} .kotak${i}`).text().toUpperCase();
          }
          // alert(jawaban);
          if(jawaban==listkata[indexrandom]){
            //benar
            alert(`Congratulations, ${$("#jumlahpemain").val()} - ${counterbaris}`);
            var temphighscore={
              "namapemain": $("#jumlahpemain").val(),
              "sekor": counterbaris
            }
            highscore.push(temphighscore);
            updateskortinggi();
            var tem = 0
            var interTemp = setInterval(() => {
              var ada=-1;
              var tempwarna="black"
              var charjawaban=jawaban.charAt(tem);
              for (let j = 0; j < 5; j++) {
                if(charjawaban==listkata[indexrandom].charAt(j)){
                  ada=tem;
                }
              }
              // alert(ada);
              if(ada!=-1){
                if(jawaban.charAt(ada)==listkata[indexrandom].charAt(ada)){
                  tempwarna="green";
                }
                else{
                  tempwarna="yellow";
                }
              }
              else{
                  tempwarna="gray";
              }
              $(`#baris${counterbaris-1} .kotak${tem+1}`).animate({
                width: '0px',
                marginLeft: '47px',
                backgroundColor:'black'

              }, 250)
              setTimeout(() => {
                $(`#baris${counterbaris-1} .kotak${tem+1}`).animate({
                  width: '75px',
                  marginLeft: '10px',
                  backgroundColor: tempwarna
                }, 250)
                tem++
              }, 250);
              if (tem == 5) {
                clearInterval(interTemp)

              }
            }, 500);

            counterbaris++




            $("#resetbtn").click();
            gameover=true;
          }
          else{
            //salah
            var tem = 0
            var interTemp = setInterval(() => {
              var ada=-1;
              var tempwarna="black"
              var charjawaban=jawaban.charAt(tem);
              for (let j = 0; j < 5; j++) {
                if(charjawaban==listkata[indexrandom].charAt(j)){
                  ada=tem;
                }
              }
              // alert(ada);
              if(ada!=-1){
                if(jawaban.charAt(ada)==listkata[indexrandom].charAt(ada)){
                  tempwarna="green";
                }
                else{
                  tempwarna="yellow";
                }
              }
              else{
                  tempwarna="gray";
              }
              $(`#baris${counterbaris-1} .kotak${tem+1}`).animate({
                width: '0px',
                marginLeft: '47px',
                backgroundColor:'black'

              }, 250)
              setTimeout(() => {
                $(`#baris${counterbaris-1} .kotak${tem+1}`).animate({
                  width: '75px',
                  marginLeft: '10px',
                  backgroundColor: tempwarna
                }, 250)
                tem++
              }, 250);
              if (tem == 5) {
                clearInterval(interTemp)

              }
            }, 500);
            if(counterbaris>=5){
              counterbaris++;
              alert("Try again later");
              gameover=true;
              $("#resetbtn").click();
            }
            else{
              counterbaris++;
              counterkotak=1;
              $(`#baris${counterbaris} .kotak${counterkotak}`).css("border","1px solid white");
            }
          }
        }
        else{
          alert("belom penuh")
          //belom penuh
        }
      }
      else{
        if(counterkotak>=6){
          alert("kotak penuh");
        }
        else{
          $(`#baris${counterbaris} .kotak${counterkotak}`).text(String.fromCharCode(event.charCode).toUpperCase());
          counterkotak++;
          for (let i = 1; i < 6; i++) {
            for (let j = 1; j < 6; j++) {
              $(`#baris${i} .kotak${j}`).css("border","1px solid rgba(255, 255, 255, 0.5)");
            }
          }
          $(`#baris${counterbaris} .kotak${counterkotak}`).css("border","1px solid white");
        }
      }
    }
  });
  $(document).keydown(function(event){
    if(event.which==8){
      if(counterkotak>=2){
        counterkotak--;
        $(`#baris${counterbaris} .kotak${counterkotak}`).text("");
          for (let i = 1; i < 6; i++) {
            for (let j = 1; j < 6; j++) {
              $(`#baris${i} .kotak${j}`).css("border","1px solid rgba(255, 255, 255, 0.5)");
            }
          }
        $(`#baris${counterbaris} .kotak${counterkotak}`).css("border","1px solid white");
      }
    }
  });
  function updateskortinggi(){
    highscore.sort( compare );
    for (let i = 0; i < highscore.length; i++) {
      $(`#nomer${i}`).text(`${i+1}. ${highscore[i].namapemain} - ${highscore[i].sekor}`)
    }
  }
  function compare( a, b ) {
    if ( a.sekor < b.sekor ){
      return -1;
    }
    if ( a.sekor > b.sekor ){
      return 1;
    }
    return 0;
  }
  

});