var list=[]
var players=[]
for (let i = 0; i < 4; i++) {
    for (let j = 0; j < 13; j++) {
        var tempnilai=-1;
        var templogo="eror"
        var tempgambar="gada"
        var tempgambar2;
        if(j==0){
            tempnilai=10
            tempgambar=13
        }
        else if(j==1){
            tempnilai=11
            tempgambar=j
        }
        else if(j>10){
            tempnilai=10
            tempgambar=j
        }
        else{
            tempnilai=j
            tempgambar=j
        }
        if(i==0){
            templogo="diamond"
            tempgambar2="Diamond"
        }
        else if(i==1){
            templogo="clover"
            tempgambar2="Clover"
        }
        else if(i==2){
            templogo="heart"
            tempgambar2="Heart"
        }
        else{
            templogo="spade"
            tempgambar2="Spade"
        }
        tempgambar=`assets/${tempgambar2}/card_${tempgambar}_${templogo}.png`
        var temp={
            "gbr":new Image(),
            "nilai":tempnilai,
            "logo":templogo,
            "setatus":true
        }
        temp.gbr.src=tempgambar
        list.push(temp)
    }
}
// console.log(list)
/*
isi pemain
list of index kartu=listidx
jumlahnilai
berhenti 
*/
var counterturn=0;
var stat=document.getElementById("status")

var btnhit=document.getElementById("hit")
var btnstand=document.getElementById("stand")
function startdiklik() {
    
    // stat.innerHTML=`Player ${counterturn+1}'s turn`
    for (let i = 0; i < 5; i++) {
        var ngewarna=document.getElementById(`player${i+1}`)
        ngewarna.style.backgroundColor="transparent"
    }
    players=[]
    counterturn=0
    for (let i = 0; i < 5; i++) {
        var player=document.getElementById(`player${i+1}`)
        player.replaceChildren();
    }
    list.forEach(x => {
        x.setatus=true;
    });
    var jumlahpemain=document.getElementById("jumlahpemain")
    if(jumlahpemain.value>=2&&jumlahpemain.value<=5){
        btnhit.style.display="inline-block"
        btnstand.style.display="inline-block"
        for (let i = 0; i < jumlahpemain.value; i++) {
            var tempnilai=0;
            var temp2=[]
            var tempindex=-1;
            while(tempnilai<22){
                var tempindex=Math.floor(Math.random() * 52);
                if(list[tempindex].setatus==true){
                    tempnilai=tempnilai+list[tempindex].nilai
                    temp2.push(tempindex)
                    list[tempindex].setatus=false;
                }else{
                    // alert("ulang")
                }
            }

            var temp={
                "listidx":temp2,
                "jumlahnilai":0,
                "posisi":0,
                "berhenti":false
            }
            players.push(temp)
            // console.log(temp2)
        }

        // console.log(players[0].listidx)
        for (let i = 0; i < players.length; i++) {
            var player=document.getElementById(`player${i+1}`)
            for (let j = 0; j < players[i].listidx.length; j++) {
                var tempkartu=document.createElement("img")
                tempkartu=list[players[i].listidx[j]].gbr
                tempkartu.setAttribute("class","kartu")
                tempkartu.setAttribute("style","display: none;")
                tempkartu.setAttribute("id",`p${i}${j}`)
                if(j!=0){
                    tempkartu.style.marginLeft="-45px"
                }
                else{
                    tempkartu.style.marginLeft="0px"
                }
                player.appendChild(tempkartu)
            }
        }
        players.forEach(x => {
            hitdiklik()
        });
    }

    else{
        alert("jumlah pemain yang diinputkan tidak valid")
    }
}
function hitdiklik(){
    
    var setop=true;
    var ctr=0;
    players.forEach(x => {
        if(x.posisi>=x.listidx.length||x.berhenti==true){

        }
        else{
            setop=false;
            ctr++
        }
    });
    var sudahmasuk=false
    if(setop==false){
        
        while(players[counterturn].posisi>=players[counterturn].listidx.length||players[counterturn].berhenti==true){
            if(counterturn==players.length-1){
                counterturn=0
            }
            else{
                counterturn++
            }
        }
        // else{
            var temp=document.getElementById(`p${counterturn}${players[counterturn].posisi}`)
            if(players[counterturn].posisi==0){
                temp.style.marginLeft="0px"
            }
            else{
                temp.style.marginLeft="-45px"
            }
            players[counterturn].jumlahnilai+=list[players[counterturn].listidx[players[counterturn].posisi]].nilai
            players[counterturn].posisi++
            temp.style.display="inline"
            temp.setAttribute("class","kartu")
        
            if(players[counterturn].jumlahnilai>21){
                players[counterturn].berhenti=true
                var temp=document.getElementById(`player${counterturn+1}`)
                var tempanak=document.createElement("div")
                tempanak.setAttribute("class",`player${counterturn+1}`)
                tempanak.style.backgroundColor="rgba(255, 0, 0, 0.3)"
                // tempanak.style.width="100px"
                // tempanak.style.height="100px"
                tempanak.innerHTML=`<p class="tulisan">OUT</p>`;
                console.log("haha")
                temp.append(tempanak);
                var adayangstand=0
                // var adapemain=0;
                var setop2=0;
                players.forEach(x => {
                    if(x.jumlahnilai<21 && x.berhenti==true){
                        adayangstand++
                    }
                    if(x.berhenti==true){
                        setop2++
                    }
                });
                console.log(adayangstand)
                console.log(setop2)

                if(setop2>=players.length&&adayangstand!=0){
                    var pemenang;
                    var skormenang=-1;
                    for (let i = 0; i < players.length; i++) {
                        if(players[i].jumlahnilai>=skormenang&&players[i].jumlahnilai<=21){
                            skormenang=players[i].jumlahnilai
                            pemenang=i+1
                        }
                    }
                    alert(`PLAYER ${pemenang} WON THE GAME`)
                    resetdiklik()
                    sudahmasuk=true;
                }
                else if(adayangstand>0&&setop2<=0){
                    var pemenang;
                    var skormenang=-1;
                    for (let i = 0; i < players.length; i++) {
                        if(players[i].jumlahnilai>=skormenang&&players[i].jumlahnilai<=21){
                            skormenang=players[i].jumlahnilai
                            pemenang=i+1
                        }
                    }
                    alert(`PLAYER ${pemenang} WON THE GAME`)
                    resetdiklik()
                    sudahmasuk=true;
                }
                else if(setop2==players.length-1&&adayangstand==0){
                    console.log("masuk sini")
                    if(counterturn==players.length-1){
                        counterturn=0
                    }
                    else{
                        counterturn++
                    }
                    while(players[counterturn].posisi>=players[counterturn].listidx.length||players[counterturn].berhenti==true){
                        if(counterturn==players.length-1){
                            counterturn=0
                        }
                        else{
                            counterturn++
                        }
                    }
                    alert(`PLAYER ${counterturn+1} WON THE GAME`)
                    resetdiklik()
                    sudahmasuk=true
                }
                // temp.style.backgroundColor="red"
                
            }
            else if(players[counterturn].jumlahnilai==21){
                alert(`BLACKJACK! PLAYER ${counterturn+1} WON THE GAME`)
                resetdiklik()
                sudahmasuk=true
            }
            if(counterturn==jumlahpemain.value-1){
                counterturn=0
            }
            else{
                counterturn++
            }
            if(sudahmasuk==false){
                while(players[counterturn].posisi>=players[counterturn].listidx.length||players[counterturn].berhenti==true){
                    if(counterturn==players.length-1){
                        counterturn=0
                    }
                    else{
                        counterturn++
                    }
                }
                stat.innerHTML=`Player ${counterturn+1}'s turn`
            }
            
        // }
    }
    else{
        //semua berhenti
        var pemenang;
        var skormenang=-1;
        for (let i = 0; i < players.length; i++) {
            if(players[i].jumlahnilai>=skormenang&&players[i].jumlahnilai<=21){
                skormenang=players[i].jumlahnilai
                pemenang=i+1
            }
        }
        alert(`PLAYER ${pemenang} WON THE GAME`)
        resetdiklik()
        sudahmasuk=true;
    }
    // if(sudahmasuk==false){
    //     ctr=0
    //     setop=true
    //     players.forEach(x => {
    //         if(x.posisi>=x.listidx.length||x.berhenti==true){
    
    //         }
    //         else{
    //             setop=false
    //             ctr++
    //         }
    //     });
    //     if(ctr==1){
    //         var seten=false;
    //         players.forEach(x => {
    //             if(x.jumlahnilai<21){
    //                 seten=true
    //             }
    //         });
    //         if(seten==false){
    //             alert(`PLAYER ${counterturn} WON THE GAME`)
    //         }
    //     }
    // }
}
function standdiklik(){
    var setop=true;
    players[counterturn].berhenti=true
    var temp=document.getElementById(`player${counterturn+1}`)
    var tempanak=document.createElement("div")
    tempanak.setAttribute("class",`player${counterturn+1}s`)
    tempanak.style.backgroundColor="rgba(255, 255, 255, 0.3)"
    // tempanak.style.width="100px"
    // tempanak.style.height="100px"
    tempanak.innerHTML=`<p class="tulisan">STAND</p>`;
    temp.append(tempanak);
    // temp.style.backgroundColor="red"
    var tempctr=0
    players.forEach(x => {
        if(x.berhenti==true){
            tempctr++
        }
    });
    if(tempctr>=5){
        var pemenang;
        var skormenang=-1;
        for (let i = 0; i < players.length; i++) {
            if(players[i].jumlahnilai>=skormenang&&players[i].jumlahnilai<=21){
                skormenang=players[i].jumlahnilai
                pemenang=i+1
            }
        }
        alert(`PLAYER ${pemenang} WON THE GAME`)
        resetdiklik()
    }
    else{
        if(counterturn==players.length-1){
            counterturn=0
        }
        else{
            counterturn++
        }
        while(players[counterturn].posisi>=players[counterturn].listidx.length||players[counterturn].berhenti==true){
            if(counterturn==players.length-1){
                counterturn=0
            }
            else{
                counterturn++
            }
        }
        stat.innerHTML=`Player ${counterturn+1}'s turn`
    }
    // players.forEach(x => {
    //     if(x.posisi>=x.listidx.length||x.berhenti==true){

    //     }
    //     else{
    //         setop=false;
    //     }
    // });
    // if(setop==false){
        
    // }
    // else{
    //     //semua berhenti
    //     var pemenang;
    //     var skormenang=-1;
    //     for (let i = 0; i < players.length; i++) {
    //         if(players[i].jumlahnilai>=skormenang&&players[i].jumlahnilai<=21){
    //             skormenang=players[i].jumlahnilai
    //             pemenang=i+1
    //         }
    //     }
    //     alert(`PLAYER ${pemenang} WON THE GAME`)
    //     resetdiklik()
    // }
}
function resetdiklik(){
    stat.innerHTML=`GAME NOT STARTED`
    for (let i = 0; i < 5; i++) {
        var ngewarna=document.getElementById(`player${i+1}`)
        ngewarna.style.backgroundColor="transparent"
        ngewarna.replaceChildren()
    }
    players=[]
    counterturn=0
    for (let i = 0; i < 5; i++) {
        var player=document.getElementById(`player${i+1}`)
        player.replaceChildren();
    }
    list.forEach(x => {
        x.setatus=true;
    });
    var tempjumlahplayer=document.getElementById("jumlahpemain")
    tempjumlahplayer.value=""
    btnhit.style.display="none"
    btnstand.style.display="none"
}