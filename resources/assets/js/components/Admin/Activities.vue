<template>
    <div class="row">
        <div class="heading">
            Etkinlikler Kısmı Düzenleme
        </div>
        <div class="add-error row" v-if="error">
            <div class=" alert alert-danger">
                Lütfen formu eksiksiz doldurunuz!
            </div>
        </div>

        <div class="add-activity" v-if="!add" @click="add = !add">
            Etkinlik Ekle
        </div>

        <div v-if="add && !update">
            <div id="activity-add">
                <div class="row">
                    <div class="col-md-12">
                        <label for="title">Etkinlik Başlığı*</label>
                        <input type="text" id="title" class="form-control" v-model="activity_title">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="margin: 0 25%;">
                        <img :src="image">
                    </div>
                    <div class="col-md-12">
                        <label for="image">Afiş*</label>
                        <input type="file" class="form-control" id="image" v-on:change="onFileChange">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="location">Konum*</label>
                        <input type="text" id="location" class="form-control" v-model="location">
                    </div>
                    <div class="col-md-6">
                        <label for="short_description">Kısa Açıklama*</label>
                        <input type="text" id="short_description" class="form-control" v-model="short_desc">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="description">Açıklama*</label>
                        <textarea name="description" id="description" cols="30" rows="3" class="form-control" v-model="description"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="category">Kategori*</label>
                        <input type="text" id="category" class="form-control" v-model="category">
                    </div>
                    <div class="col-md-6">
                        <label for="date">Tarih*</label>
                        <input type="text" id="date" class="form-control" v-model="date">
                    </div>
                </div>

                <button class="btn btn-lg" @click="addActivity">Etkinlik Ekle</button>
            </div>
        </div>

        <div v-if="update && !add">
            <div id="activity-add">
                <div class="row">
                    <div class="col-md-6">
                        <label for="title">Etkinlik Başlığı*</label>
                        <input type="text" id="title" class="form-control" v-model="activity_title">
                    </div>
                    <div class="col-md-6">
                        <label for="title">URL*</label>
                        <input type="text" id="title" class="form-control" v-model="url" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="location">Konum*</label>
                        <input type="text" id="location" class="form-control" v-model="location">
                    </div>
                    <div class="col-md-6">
                        <label for="short_description">Kısa Açıklama*</label>
                        <input type="text" id="short_description" class="form-control" v-model="short_desc">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="description">Açıklama*</label>
                        <textarea name="description" id="description" cols="30" rows="3" class="form-control" v-model="description"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="category">Kategori*</label>
                        <input type="text" id="category" class="form-control" v-model="category">
                    </div>
                    <div class="col-md-6">
                        <label for="date">Tarih*</label>
                        <input type="text" id="date" class="form-control" v-model="date">
                    </div>
                </div>

                <button class="btn btn-lg" @click="updateActivityData">Etkinlik Güncelle</button>
            </div>
        </div>

        <div class="activities" v-if="!add && !update">
            <div class="activity" v-for="(activity, index) in allActivities">
                <i class="fa fa-close" @click="deleteActivity(index,activity.id)"></i>
                <i class="fa fa-refresh" @click="updateActivity(activity)"></i>
                <div class="activity-title">
                    {{ activity.activity_title }}
                </div>
                <div class="activity-image">
                    <img :src="'/' + activity.image_path" alt="img">
                </div>
                <div class="activity-short-desc">
                    <h1>Kısa Açıklama</h1>
                    <div>{{ activity.short_description }}</div>
                </div>
                <div class="activity-description">
                    <h1>Açıklama</h1>
                    <div>{{ activity.description }}</div>
                </div>
                <table class="activity-meta">
                    <tr>
                        <td class="activity-category">Kategori</td>
                        <td class="activity-category">{{ activity.category }}</td>
                    </tr>
                    <tr>
                        <td class="activity-date">Tarih</td>
                        <td class="activity-date">{{ activity.date }}</td>
                    </tr>
                    <tr>
                        <td class="activity-state">Mekan</td>
                        <td class="activity-state">{{ activity.location }}</td>
                    </tr>
                    <tr>
                        <td class="activity-state">URL</td>
                        <td class="activity-state">{{ activity.url }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['activities'],

        data(){
            return {
                activity_title: '',
                location: '',
                short_desc: '',
                description: '',
                image: '',
                category: '',
                date: '',
                url: '',
                allActivities: [],
                add: false,
                update: false,
                created: false,
                updated: false,
                error: false,
            }
        },

        created() {
            this.allActivities = this.activities;
        },

        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            addActivity(){
                let formData = new FormData();
                let imagefile = document.querySelector('#image');
                formData.append('image', imagefile.files[0]);
                formData.append('name', this.activity_title);
                formData.append('short_desc', this.short_desc);
                formData.append('long_desc', this.description);
                formData.append('location', this.location);
                formData.append('category', this.category);
                formData.append('date', this.date);


                const headers = {
                    'Content-Type': 'multipart/form-data'
                };

                axios.post('/admin/activities', formData, headers).then((response) => {
                    if(response.status == 200){
                        this.$swal('Eklendi!', 'Yeni etkinlik eklendi', 'success');
                        setTimeout(function(){
                            window.location.href = '/admin/activities'
                        }, 2000);
                    }           
                    else {
                        this.$swal('Hata', 'Hata dolayısıyla devam edilemedi', 'error');
                    }         
                });
            },

            deleteActivity(index,activity_id){
                var self = this;
                this.$swal({
                    title: 'Emin misin?',
                    text: "Sildiğin etkinliği geri alamazsın!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, sil!',
                    cancelButtonText: 'Hayır'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/admin/activities',{
                            params: {activity_id: activity_id}
                        }).then(response => {
                            if(response.status === 200){
                                self.$swal(
                                    'Silindi!',
                                    'Etkinlik silindi.',
                                    'success'
                                );
                                self.allActivities.splice(index,1);
                            }
                        });

                    }
                });

            },
            updateActivity(activity){
                this.activity_title = activity.activity_title;
                this.location =  activity.location;
                this.short_desc = activity.short_description;
                this.description = activity.description;
                this.image = activity.image;
                this.category = activity.category;
                this.date = activity.date;
                this.url = activity.url;
                this.update = true;
            },
            updateActivityData(){
                let formData = new FormData();
                formData.append('url', this.url);
                formData.append('name', this.activity_title);
                formData.append('short_desc', this.short_desc);
                formData.append('long_desc', this.description);
                formData.append('location', this.location);
                formData.append('category', this.category);
                formData.append('date', this.date);

                const headers = {
                    'Content-Type': 'multipart/form-data'
                };

                axios.post('/admin/activities/update', formData, headers).then((response) => {
                    if(response.status == 200){
                        this.$swal('Güncellendi', 'Etkinlik güncellendi', 'success');
                        setTimeout(function(){
                            window.location.href = '/admin/activities'
                        }, 2000);
                    }           
                    else {
                        this.$swal('Hata', 'Hata dolayısıyla devam edilemedi', 'error');
                    }         
                });
            }
        }
    }

</script>

<style>
    div.activity-description div {
        word-wrap: break-word;
    }
</style>