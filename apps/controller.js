angular.module("Ctrl", [])
    .controller("MainController", function($scope, $rootScope, Services) {
        $scope.Init = function() {

        };
    })
    .controller("headerController", function($scope, $rootScope, Services) {
        $scope.Init = function() {
            Services.Authentification();
        }

    })
    .controller("RegisterController", function($scope, $http) {
        $scope.username = '';
        $scope.email = '';
        $scope.passw1 = '';
        $scope.passw2 = '';
        $scope.DatasUser = {};

        $scope.edit = true;
        $scope.error = false;
        $scope.incomplete = true;
        $scope.hideform = true;



        //$scope.$watch('passw1', function() { $scope.test(); });
        $scope.$watch('passw2', function() { $scope.test(); });
        $scope.$watch('username', function() { $scope.test(); });
        $scope.$watch('email', function() { $scope.test(); });

        $scope.test = function() {
            if ($scope.passw1 !== $scope.passw2) {
                $scope.error = true;
            } else {
                $scope.error = false;
            }
            $scope.incomplete = false;
            if ($scope.edit && (!$scope.username.length ||
                    !$scope.email.length ||
                    !$scope.passw1.length || !$scope.passw2.length)) {
                $scope.incomplete = true;
            }
        };

        $scope.Signup = function() {
            $scope.DatasUser.username = $scope.username;
            $scope.DatasUser.email = $scope.email;
            $scope.DatasUser.password = $scope.passw1;
            var Data = $scope.DatasUser;
            var UrlSignup = "../../api/datas/create/Signup.php";
            $http({
                    method: "POST",
                    url: UrlSignup,
                    data: Data
                })
                .then(function(response) {
                    if (response.data.message == "Pesan telah terkirim.") {
                        var mess = response.data.message + " ke Email Anda, Silahkan buka email anda untuk melakukan Activation!";
                        alert(mess);
                        window.location.href = '../../index.html';
                    } else {
                        alert(response.data.message);
                    }

                }, function(error) {
                    alert(error)
                })
        };
    })
    .controller("KriteriaController", function($scope, $http) {
        $scope.DatasKriteria = [];
        $scope.DataInputKriteria = {};
        $scope.DataInput = {};
        $scope.Init = function() {
            var UrlGetKriteria = "api/datas/read/ReadKriteria.php";
            $http({
                    method: "GET",
                    url: UrlGetKriteria
                })
                .then(function(response) {
                    if (response.data.message == "Kriteria found")
                        $scope.DatasKriteria = response.data.Kriteria;
                    else
                        alert(response.data.message);

                }, function(error) {
                    alert(error);
                })
        }
        $scope.Simpan = function() {
            var UrlSimpan = "api/datas/create/CreateKriteria.php";
            var Data = $scope.DataInputKriteria;
            $http({
                    method: "POST",
                    url: UrlSimpan,
                    data: Data
                })
                .then(function(response) {
                    if (response.data.IdKriteria != 0 || response.data.IdKriteria != undefined) {
                        Data.IdKriteria = response.data.IdKriteria;
                        $scope.DatasKriteria.push(angular.copy(Data));
                        alert("Data disimpan!!");
                    } else
                        alert(response.data.message);
                }, function(error) {
                    alert(error);
                })
        }
        $scope.GetIdKriteria = function(ItemKriteria) {
            $scope.DataInput.IdKriteria = angular.copy(ItemKriteria.IdKriteria);
        }
        $scope.GetItemKriteria = function(item) {
            $scope.DataInput = angular.copy(item);
        }
        $scope.GetItemSubKriteria = function(item) {
            $scope.DataInput = angular.copy(item);
        }
        $scope.SimpanSubKriteria = function() {
            var UrlSubKriteria = "api/datas/create/CreateSubKriteria.php";
            var Data = angular.copy($scope.DataInput);
            $http({
                    method: "POST",
                    url: UrlSubKriteria,
                    data: Data
                })
                .then(function(response) {
                    if (response.data.IdSubKriteria != undefined && response.data.IdSubKriteria != 0) {
                        angular.forEach($scope.DatasKriteria, function(value, key) {
                            if (value.IdKriteria == Data.IdKriteria) {
                                var temp = {};
                                temp.IdSubKriteria = response.data.IdSubKriteria;
                                temp.Jarak = Data.Jarak;
                                temp.BobotSubKriteria = Data.BobotSubKriteria;
                                value.SubKriteria.push(angular.copy(temp));
                                //$scope.DataInput = {};
                                window.location.href = 'admin.html#!/Kriteria';
                            }
                        });
                    }
                }, function(error) {
                    alert(error);
                });
        }
        $scope.UpdateKriteria = function() {
            var UrlUpdateKriteria = "api/datas/update/UpdateKriteria.php";
            var Data = angular.copy($scope.DataInput);
            $http({
                    method: "POST",
                    url: UrlUpdateKriteria,
                    data: Data
                })
                .then(function(response) {
                    if (response.data.message === "Data Berhasil Simpan!") {
                        angular.forEach($scope.DatasKriteria, function(value, key) {
                            if (value.IdKriteria == Data.IdKriteria) {
                                value.Kriteria = Data.Kriteria;
                                value.Bobot = Data.Bobot;
                                value.Keterangan = Data.Keterangan
                            }
                        });
                        alert(response.data.message);
                        $scope.DataInput = {};
                    } else
                        alert(response.data.message);
                }, function(error) {
                    alert(error)
                });
        }
        $scope.UpdateSubKriteria = function() {
            var UrlUpdateSubKriteria = "api/datas/update/UpdateSubKriteria.php";
            var Data = angular.copy($scope.DataInput);
            $http({
                    method: "POST",
                    url: UrlUpdateSubKriteria,
                    data: Data
                })
                .then(function(response) {
                    if (response.data.IdKriteria > 0) {
                        angular.forEach($scope.DatasKriteria, function(val1, ke1) {
                            if (val1.IdKriteria == response.data.IdKriteria) {
                                angular.forEach(val1.SubKriteria, function(val2, key2) {
                                    if (val2.IdSubKriteria == Data.IdSubKriteria) {
                                        val2.Jarak = Data.Jarak;
                                        val2.BobotSubKriteria = Data.BobotSubKriteria;
                                        alert("Data Berhasil Disimpan");
                                        $scope.DataInput = {};
                                    }
                                });
                            }
                        });
                    } else
                        alert(response.data.message);
                }, function(error) {
                    alert(error);
                });
        }
        $scope.DeleteSubKriteria = function(item) {
            var UrlDelSub = "api/datas/delete/DeleteSubKriteria.php";
            $scope.DataInput = item
            var Data = angular.copy($scope.DataInput.IdSubKriteria);
            $http({
                    method: "POST",
                    url: UrlDelSub,
                    data: Data
                })
                .then(function(response) {
                    if (response.data.IdKriteria > 0) {
                        angular.forEach($scope.DatasKriteria, function(val1, key1) {
                            if (val1.IdKriteria == response.data.IdKriteria) {
                                val1.SubKriteria.splice($scope.DataInput, 1);
                                alert("Data Berhasil di Hapus");
                            }
                        });
                    } else
                        alert(response.data.message);
                }, function(error) {
                    alert(error);
                })
        }
    })
    .controller("MahasiswaKriteriaController", function($scope, $http, $sce) {
        $scope.DatasKriteria = [];
        $scope.Biodata = {};
        $scope.DataForm = {};
        $scope.InputData = {};
        $scope.tampilAdd = false;
        $scope.showData = true;
        $scope.showadd = true;
        $scope.tampilData = false;
        $scope.pdfUrl;
        $scope.Init = function() {
            var UrlVerifikasiData = "api/datas/read/VerifikasiData.php";
            $http.get(UrlVerifikasiData).then(function(response) {
                //$scope.NPM = response.data.Biodata[0].NPM;
                $scope.Biodata = angular.copy(response.data.Biodata[0]);
                if ($scope.Biodata.NPM != null || $scope.Biodata.NamaMahasiswa != null || $scope.Biodata.Kontak != null || $scope.Biodata.Kelas != null || $scope.Biodata.Alamat != null || $scope.Biodata.Photo != null) {
                    $scope.tampil = false;
                    var UrlGetKriteria = "api/datas/read/ReadKriteriaMahasiswa.php";
                    $http({
                            method: "GET",
                            url: UrlGetKriteria
                        })
                        .then(function(response) {
                            if (response.data.message == "Kriteria found")
                                $scope.DatasKriteria = angular.copy(response.data.Kriteria);
                            else
                                alert(response.data.message);

                        }, function(error) {
                            alert(error);
                        })
                } else {
                    alert("Lengkapi Biodata Anda terlebih dahulu");
                    window.location.href = 'mahasiswa.html#!/Mahasiswa';
                }
            });

        }

        $scope.pdfName = 'test';
        $scope.scroll = 0;
        $scope.loading = 'loading';

        $scope.getNavStyle = function(scroll) {
            if (scroll > 100) return 'pdf-controls fixed';
            else return 'pdf-controls';
        }

        $scope.onError = function(error) {
            console.log(error);
        }

        $scope.onLoad = function() {
            $scope.loading = '';
        }

        $scope.onProgress = function(progressData) {
            console.log(progressData);
        };
        $scope.ShowForm = function(item) {
            $scope.pdfUrl = undefined;
            $scope.InputData = {};
            $scope.DataForm = item;
            $scope.tampilData = true;
            $scope.showData = false;
            $scope.tampilAdd = false;
            $scope.showadd = true;
            $scope.InputData.IdKriteria = item.IdKriteria;
            $scope.InputData.SubKriteria = item.SubKriteria;
            if (item.Nilai != null) {
                $scope.InputData.Nilai = item.Nilai;
                $scope.InputData.Berkas = item.KriteriaMhasiswa[0].Berkas;
                $scope.pdfUrl = "assets/berkas/" + $scope.InputData.Berkas;
                angular.forEach(item.SubKriteria, function(value, key) {
                    if (value.BobotSubKriteria == item.Nilai) {
                        $scope.InputData.Jarak = value.Jarak;
                    }
                })
            }
        }
        $scope.FormEdit = function() {
            $scope.tampilData = false;
            $scope.showData = true;
            $scope.tampilAdd = true;
            $scope.showadd = false;
        }
        $scope.uploadedFile = function(element) {
            var reader = new FileReader();
            reader.onload = function(event) {
                $scope.$apply(function($scope) {
                    $scope.files = element.files;
                    $scope.src = event.target.result
                });
            }
            reader.readAsDataURL(element.files[0]);
        }
        $scope.Save = function() {
            $http({
                    url: "http://localhost/bidikmisi/api/datas/create/uploadBerkas.php", //or your add enquiry services
                    method: "POST",
                    processData: true,
                    headers: { 'Content-Type': undefined },
                    data: $scope.formdata,
                    transformRequest: function(data) {
                        var formData = new FormData();
                        var file = $scope.files[0];
                        //var data = $base64.encode(file);
                        formData.append("file_upload", file); //pass the key name by which we will recive the file
                        angular.forEach(data, function(value, key) {
                            formData.append(key, value);
                        });

                        return formData;
                    }
                })
                .then(function(response) {
                    if (response.data.message == "Success") {
                        $scope.InputData.Berkas = response.data.namefile;
                        var Data = $scope.InputData;
                        var urlkriteria = "api/datas/create/CreateKriteriaMahasiswa.php";
                        $http({
                                method: "POST",
                                url: urlkriteria,
                                data: Data
                            })
                            .then(function(response) {
                                if (response.data.message > 1) {
                                    $scope.tampilData = true;
                                    $scope.showData = false;
                                    $scope.tampilAdd = false;
                                    $scope.showadd = true;
                                    angular.forEach($scope.InputData.SubKriteria, function(value, key) {
                                        if (value.BobotSubKriteria == $scope.InputData.Nilai) {
                                            $scope.InputData.Jarak = value.Jarak;
                                        }
                                    })
                                    angular.forEach($scope.DatasKriteria, function(value, key) {
                                        if (value.IdKriteria == $scope.InputData.IdKriteria) {
                                            value.Nilai = $scope.InputData.Nilai;
                                            value.KriteriaMhasiswa[0].Berkas = $scope.InputData.Berkas;
                                            value.KriteriaMhasiswa[0].Nilai = $scope.InputData.Nilai;
                                            value.KriteriaMhasiswa[0].Status = "Pending";
                                            $scope.pdfUrl = "assets/berkas/" + $scope.InputData.Berkas;
                                        }
                                    })
                                }
                            }, function(error) {
                                alert(error);
                            })
                    }

                }, function(error) {

                });

        }
    })
    .controller("LoginController", function($scope, $http) {
        $scope.DatasLogin = {};
        $scope.Login = function() {
            var UrlLogin = "api/datas/read/UserLogin.php";
            var Data = angular.copy($scope.DatasLogin);
            $http({
                    method: "POST",
                    url: UrlLogin,
                    data: Data
                })
                .then(function(response) {
                    if (response.data.Session != undefined) {
                        if (response.data.Session.Akses == "Mahasiswa")
                            window.location.href = "mahasiswa.html";
                        else
                            window.location.href = "admin.html";
                    } else
                        alert(response.data.message);

                }, function(error) {
                    alert(error);
                })
        }

    })
    .controller("MahasiswaController", function($scope, $http) {
        $scope.DataVerifikasi = [];
        $scope.DataVerifikasi.Biodata = {};
        $scope.Init = function() {
            var UrlVerifikasiData = "api/datas/read/VerifikasiData.php";
            $http.get(UrlVerifikasiData).then(function(response) {
                //$scope.NPM = response.data.Biodata[0].NPM;
                $scope.DataVerifikasi.Biodata = response.data.Biodata[0];
            });
        }
        $scope.uploadedFile = function(element) {
            var reader = new FileReader();
            reader.onload = function(event) {
                $scope.$apply(function($scope) {
                    $scope.files = element.files;
                    $scope.src = event.target.result
                });
            }
            $scope.DataVerifikasi.Biodata.Photo = element.files[0].name;
            reader.readAsDataURL(element.files[0]);
        }
        $scope.Simpan = function() {
            $http({
                    url: "http://localhost/bidikmisi/api/datas/create/upload.php", //or your add enquiry services
                    method: "POST",
                    processData: true,
                    headers: { 'Content-Type': undefined },
                    data: $scope.formdata,
                    transformRequest: function(data) {
                        var formData = new FormData();
                        var file = $scope.files[0];
                        //var data = $base64.encode(file);
                        formData.append("file_upload", file); //pass the key name by which we will recive the file
                        angular.forEach(data, function(value, key) {
                            formData.append(key, value);
                        });

                        return formData;
                    }
                })
                .then(function(response) {
                    var urlmahasiswa = "api/datas/create/CreateMahasiswa.php";
                    if (response.data.message == "Success") {
                        $http({
                                method: "POST",
                                url: urlmahasiswa,
                                data: $scope.DataVerifikasi.Biodata
                            })
                            .then(function(response) {

                            }, function(error) {
                                alert(error);
                            })
                    }

                }, function(error) {

                });
        }

    })
    .controller("ListMahasiswaController", function($scope, $http) {
        $scope.DatasMahasiswas = [];
        $scope.EditBerkas = {};
        $scope.pdfUrl;
        $http.get('api/datas/read/ReadDataMahasiswa.php').then(function(response) {
            //$scope.NPM = response.data.Biodata[0].NPM;
            $scope.DatasMahasiswas = response.data.record;
        });
        $scope.pdfName;
        $scope.scroll = 0;
        $scope.loading = 'loading';

        $scope.getNavStyle = function(scroll) {
            if (scroll > 100) return 'pdf-controls';
            else return 'pdf-controls';
        }

        $scope.onError = function(error) {
            console.log(error);
        }

        $scope.onLoad = function() {
            $scope.loading = '';
        }

        $scope.onProgress = function(progressData) {
            console.log(progressData);
        }
        $scope.Verivikasi = function(item) {
            $scope.pdfUrl = "assets/berkas/" + item.KriteriaMahasiswa[0].Berkas;
            $scope.pdfName = item.KriteriaMahasiswa[0].Berkas;
            $scope.EditBerkas = item;
        }
        $scope.SelectedMahasiswa = function() {
            angular.forEach($scope.DatasMahasiswas, function(value, key) {

            })
        }
        $scope.ValidateKriteria = function() {
            $http({
                    method: "POST",
                    url: "api/datas/update/ValidateKriteria.php",
                    data: $scope.EditBerkas.KriteriaMahasiswa[0].IdKriteriaMahasiswa
                })
                .then(function(response) {
                    if (response.data.message == "Success!!!") {
                        $scope.EditBerkas.KriteriaMahasiswa[0].Status = "true";
                        alert(response.data.message);
                    } else
                        alert(response.data.message);
                }, function(error) {
                    alert(error);
                })
        }

    })
    .controller("SeleksiController", function($scope, $http, $filter) {
        $scope.Datas = [];
        $scope.DatasPilih = [];
        $scope.DatasProses = [];
        $scope.Dataselected = {};
        $scope.a;
        $scope.AlternatifAkhir = [];
        $http.get('api/datas/read/ReadDataProses.php').then(function(response) {
            //$scope.NPM = response.data.Biodata[0].NPM;
            $scope.Datas = response.data;
            angular.forEach($scope.Datas.Mahasiswas, function(value1, key1) {
                value1.Cheked = "Tidak";
                $scope.a = false;
                angular.forEach($scope.Datas.Years, function(value2, key2) {
                    if (value1.TahunAjaran == value2.IdTahunAjaran) {
                        value1.Year = angular.copy(value2.TahunAjaran);
                    }
                })

                angular.forEach($scope.Datas.HasilAkhir, function(value3, key3) {
                    if (value1.IdMahasiswa == value3.IdMahasiswa) {
                        $scope.a = true;
                    }
                })
                angular.forEach(value1.Kriterias, function(value4, key4) {
                    if (value4.Status == "pending") {
                        $scope.a = true;
                    }
                })
                if ($scope.a == false) {
                    $scope.DatasPilih.push(angular.copy(value1));
                }
            })
        });
        $scope.check = function() {
            var a = $scope.Dataselected;
        }
        $scope.PilihData = function(item) {
            if (item.Cheked == "Pilih") {
                item.Cheked = "Tidak";
                $scope.DatasProses.splice(item, 1);
            } else {
                item.Cheked = "Pilih";
                $scope.DatasProses.push(angular.copy(item));
            }

        }
        $scope.TotalMatriks = function(item) {
            var total = 0;
            angular.forEach($scope.MatriksNormalisasi, function(value, key) {
                angular.forEach(value.Kriterias, function(value1, key1) {
                    if (value1.Kriteria == item)
                        total += value1.Nilai;
                })
            })
            return total;
        }
        $scope.Proses = function() {
            $scope.AlternatifAkhir = [];
            $scope.PositifValue = [];
            $scope.NegatifValue = [];
            $scope.JarakPositifNegatifValue = [];
            $scope.Matriks = [];
            $scope.MatriksNormalisasi = [];
            $scope.NormalisasiTerbobot = [];
            $scope.Matriks = angular.copy($scope.DatasProses);
            $scope.MatriksNormalisasi = angular.copy($scope.DatasProses);
            angular.forEach($scope.MatriksNormalisasi, function(value, key) {
                angular.forEach(value.Kriterias, function(value1, key1) {
                    var a = angular.copy(value1.Nilai);
                    value1.Nilai = Math.pow(a, 2);
                })
            })
            angular.forEach($scope.Matriks, function(value, key) {
                angular.forEach(value.Kriterias, function(value1, key1) {
                    var total = 0;
                    total = angular.copy($scope.TotalMatriks(value1.Kriteria));
                    var a = 0;
                    a = angular.copy(value1.Nilai) / Math.sqrt(total);
                    value1.Nilai = a;
                })
            });
            $scope.GetMaxValue = function(item) {
                var Datatampung = [];

                angular.forEach($scope.NormalisasiTerbobot, function(value, key) {
                    angular.forEach(value.Kriterias, function(val1, key1) {
                        if (val1.Kriteria == item) {
                            Datatampung.push(angular.copy(val1.Nilai));
                        }
                    })
                })
                var c = 0;
                c = Math.max.apply(Math, Datatampung.map(function(item1) { return item1; }));
                return c;
            }
            $scope.GetMinValue = function(item) {
                var Datatampung = [];

                angular.forEach($scope.NormalisasiTerbobot, function(value, key) {
                    angular.forEach(value.Kriterias, function(val1, key1) {
                        if (val1.Kriteria == item) {
                            Datatampung.push(angular.copy(val1.Nilai));
                        }
                    })
                })
                var c = 0;
                c = Math.min.apply(Math, Datatampung.map(function(item1) { return item1; }));
                return c;
            }
            $scope.NormalisasiTerbobot = angular.copy($scope.Matriks);
            angular.forEach($scope.NormalisasiTerbobot, function(value, key) {
                angular.forEach(value.Kriterias, function(value1, key1) {
                    var a = angular.copy(value1.Nilai);
                    var b = parseInt(value1.Bobot) / 100;
                    value1.Nilai = a * b;
                })
            })
            $scope.NilaiPositif = function() {
                var NilaiDatas = [];
                angular.forEach($scope.NormalisasiTerbobot[0].Kriterias, function(value, key) {
                    var Datass = {};
                    if (value.Jenis == "Benefit") {
                        var a = $scope.GetMaxValue(value.Kriteria);
                        Datass.Kriteria = value.Kriteria;
                        Datass.Nilai = a;
                        NilaiDatas.push(angular.copy(Datass));
                    } else {
                        var a = $scope.GetMinValue(value.Kriteria);
                        Datass.Kriteria = value.Kriteria;
                        Datass.Nilai = a;
                        NilaiDatas.push(angular.copy(Datass));
                    }
                })
                return NilaiDatas;
            }
            $scope.NilaiNegatif = function() {
                var NilaiDatas = [];
                angular.forEach($scope.NormalisasiTerbobot[0].Kriterias, function(value, key) {
                    var Datass = {};
                    if (value.Jenis == "Cost") {
                        var a = $scope.GetMaxValue(value.Kriteria);
                        Datass.Kriteria = value.Kriteria;
                        Datass.Nilai = a;
                        NilaiDatas.push(angular.copy(Datass));
                    } else {
                        var a = $scope.GetMinValue(value.Kriteria);
                        Datass.Kriteria = value.Kriteria;
                        Datass.Nilai = a;
                        NilaiDatas.push(angular.copy(Datass));
                    }
                })
                return NilaiDatas;
            }
            $scope.PositifValue = $scope.NilaiPositif();
            $scope.NegatifValue = $scope.NilaiNegatif();
            $scope.NilaiJarakPositifNegatif = function() {
                var NilaiDatas = [];
                var alternatif = 1;
                angular.forEach($scope.NormalisasiTerbobot, function(value, key) {
                    var a = 0;
                    var b = {};
                    var c = 0;
                    angular.forEach(value.Kriterias, function(value1, key1) {
                        angular.forEach($scope.PositifValue, function(value2, key2) {
                            if (value1.Kriteria == value2.Kriteria) {
                                a += Math.pow(value1.Nilai - value2.Nilai, 2);
                            }
                        })
                        angular.forEach($scope.NegatifValue, function(value2, key2) {
                            if (value1.Kriteria == value2.Kriteria) {
                                c += Math.pow(value1.Nilai - value2.Nilai, 2);
                            }
                        })
                    })
                    b.NamaMahasiswa = value.NamaMahasiswa;
                    b.Alternatif = "A" + alternatif;
                    b.NilaiPositif = Math.sqrt(a);
                    b.NilaiNegatif = Math.sqrt(c);
                    alternatif++;
                    NilaiDatas.push(angular.copy(b));

                })
                return NilaiDatas;
            }
            $scope.JarakPositifNegatifValue = $scope.NilaiJarakPositifNegatif();
            $scope.alternatifAkhir = function() {
                var Datass = [];
                angular.forEach($scope.JarakPositifNegatifValue, function(value, key) {
                    var a = 0;
                    var b = {};
                    a = (value.NilaiNegatif / (value.NilaiPositif + value.NilaiNegatif));
                    b.NamaMahasiswa = value.NamaMahasiswa;
                    b.Alternatif = value.Alternatif;
                    b.NilaiAkhir = a;
                    Datass.push(angular.copy(b));
                })
                return Datass;
            }
            $scope.AlternatifAkhir = $scope.alternatifAkhir();
            $scope.AlternatifAkhir = $filter('orderBy')($scope.AlternatifAkhir, 'NilaiAkhir', true);
            console.log(JSON.stringify($scope.AlternatifAkhir));
        }
    });