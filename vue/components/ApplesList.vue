<template>
    <div class="apples">
        <h1>Список яблочек</h1>
        
        <audio id="apple-falling" src="http://sprott.physics.wisc.edu/wop/sounds/ShipCrash-2.wav" autostart="false" ></audio>
        <audio id="apple-eating" src="http://www.sounds.beachware.com/2illionzayp3may/wlvwsikf/CHEWING.mp3" autostart="false" ></audio>        
        
        <div class='row'>
            <div class='col-lg-6'><a class="btn btn-lg btn-success" href="#" @click="generateApplesList()">Генерировать яблоки</a></div>
            <div class='col-lg-6 text-right'>Всего {{apples.length}}</div>
        </div>
        
        <h2>На дереве</h2>
        
        <div class='row' id="tree-apples-list">
            <div v-bind:id="'apple-'+apple.id" class="col-lg-2" v-for="apple in onTreeApples(apples)" :key="apple.id" v-bind:style="{background: apple.color}">
                <div>#{{apple.id}}</div>
                <div>Создано:{{apple.creation_date}}</div>
                <div v-if="apple.fall_date">Упало:{{apple.fall_date}}</div>
                <button class="btn btn-sm btn-warning" @click="dropApple(apple.id)">Упасть</button>
            </div>
        </div>
        
        <h2>На земле</h2>
        
        <div class="row" id="ground-apples-list">
            <div v-bind:id="'apple-'+apple.id" class="col-lg-2" v-for="apple in onGroundApples(apples)" :key="apple.id" v-bind:style="{background: apple.color}">
                <div>#{{apple.id}}</div>
                <div>Создано:{{apple.creation_date}}</div>
                <div v-if="apple.fall_date">Упало:{{apple.fall_date}}</div>
                
                <div>Здоровье: {{apple.size}}%</div>
                
                <div v-if="apple.state == 2">
                    <div class="input-group">
                        <input type='number' v-bind:id="'apple-eat-'+apple.id" class="form-control" value="" />
                        <div class="input-group-addon">ед.</div>
                    </div>
                    <button class="btn btn-sm btn-warning" @click="eatApple(apple.id)">Съесть</button>
                </div>
                <div v-else-if="apple.state == 3">
                    Гнилое
                </div>
            </div>
        </div>
        
        <h2>Съеденные</h2>
        
        <div class="row" id="ground-apples-list">
            <div v-bind:id="'apple-'+apple.id" class="col-lg-2" v-for="apple in deletedApples(apples)" :key="apple.id" v-bind:style="{background: apple.color}">
                <div>#{{apple.id}}</div>
                <div>Создано:{{apple.creation_date}}</div>
                <div v-if="apple.fall_date">Упало:{{apple.fall_date}}</div>
                
                <div>Здоровье: {{apple.size}}%</div>
            </div>            
        </div>
        
    </div>
</template>
<script>    
import axios from 'axios';
//as ajax
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export default {
    data() {
      return {
          apples: [],
      }  
    },    
    created() {        
        this.loadApplesList();
    },
    methods: {
        loadApplesList() {
            axios
              .get("/apple/get-list")
              .then(response => (this.apples = response.data))
              .catch(error => console.log(error));
        },
        generateApplesList() {
            axios
              .get("/apple/generate")
              .then(response => (this.apples = response.data))
              .catch(error => console.log(error));
        },
        dropApple(id) {
            
          document.getElementById("apple-falling").play();
            
            axios
              .get("/apple/drop/"+id)
              .then(response => (this.apples = response.data))
              .catch(error => console.log(error));  
        },
        eatApple(id) {
            
            document.getElementById("apple-eating").play();
            
            var apple = document.getElementById("apple-eat-"+id);
            
            axios
              .get("/apple/eat/"+id+"/"+apple.value)
              .then(response => (this.apples = response.data))
              .catch(error => console.log(error));
      
            apple.value = '';
        },
        

        onTreeApples(apples) {
            return apples.filter(function (apple) {
              return apple.state == 1;
            })
        },
        
        onGroundApples(apples) {
            return apples.filter(function (apple) {
              return apple.state == 2 || apple.state == 3;
            })
        },
        
        deletedApples(apples) {
            return apples.filter(function (apple) {
              return apple.state == 4;
            })
        },

    },

}
</script>

<style scoped>
    .apples {
        border: 1px solid grey;
        border-radius: 10px;
        margin: 10px;
        padding: 10px;  
    }
    
    #tree-apples-list {

        margin-top: 20px;
    }
    
    #tree-apples-list > div, #ground-apples-list > div {

        height: 200px; 
        width: 200px;

        padding: 10px;
        border-radius: 100px;
        border: 1px solid black;
        text-align: center;
        font-size: 0.8em;
    }
    
    #ground-apples-list {
            
    }


</style>