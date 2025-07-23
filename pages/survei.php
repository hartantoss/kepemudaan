<style>
  .survey-container {
    max-width: 800px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
  }

  .btn{
    color:white !important;
    border:none !important;
  }
  .survey-step {
    display: none;
  }

  .survey-step.active {
    display: block;
  }

  .progress {
    background-color: #e0e0e0;
    height: 12px;
    border-radius: 8px;
    overflow: hidden;
  }

  .progress-bar {
    height: 100%;
    background-color: #1e3a8a;
    width: 0;
    transition: width 0.3s;
  }

  /* .question-img {
    display: block;
    max-width: 100px;
    margin: 10px auto;
  } */

  .question-img {
    display: block;
    max-width: 300px;     /* ukuran lebih besar */
    width: auto;           /* responsif, maksimal 300px */
    height: auto;
    margin: 20px auto 30px auto;  /* jarak atas lebih luas dan bawah juga */
    object-fit: contain;   /* supaya gambar tidak terdistorsi */
  }
  .navigation-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
  }

  h5.question-title {
    font-weight: 600;
    color: #333;
  }

  
</style>



<div class="container" style="margin-bottom:10%">
  <div class="survey-container">
    <div class="progress"><div class="progress-bar" id="progressBar"></div></div>

    <!-- Step 1: User Info -->
    <div class="survey-step active" style="margin-bottom:150px;">
      <h5 class="center-align">Informasi Responden</h5>
      <div class="input-field"><input type="text" id="nama"><label for="nama">Nama<span style="color:red">*</span></label></div>
      <div class="input-field"><input type="number" id="umur"><label for="umur">Umur<span style="color:red">*</span></label></div>
      <div class="input-field"><input type="tel" id="hp"><label for="hp">No. HP<span style="color:red">*</span></label></div>
      <div class="input-field">
        <select id="gender">
          <option value="" disabled selected>Pilih Jenis Kelamin<span style="color:red">*</span></option>
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
        <label>Jenis Kelamin</label>
      </div>
      <div class="navigation-buttons center-align">
        <button class="btn blue darken-3" onclick="nextStep()">Mulai Survei</button>
      </div>
    </div>

    <!-- Survey Questions 2 to 12 -->
    <div id="surveySteps"></div>

    <!-- Final Submit -->
    <div class="survey-step">
      <h5 class="center-align">Terima kasih telah mengisi survei!</h5>
      <p class="center-align">Data Anda telah direkam.</p>
    </div>
  </div>
</div>



<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- JavaScript for Survey -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
      M.FormSelect.init(document.querySelectorAll('select'));
    });

    const answerValues = { a: 1, b: 2, c: 3, d: 4 };
    const answers = [];

    const questions = [
      {
        q: "Bagaimana pendapat Saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya?",
        img: "1.svg",
        options: ["Tidak sesuai", "Kurang sesuai", "Sesuai", "Sangat sesuai"],
        required: true
      },
      {
        q: "Bagaimana pemahaman Saudara tentang kemudahan prosedur pelayanan di unit ini?",
        img: "2.svg",
        options: ["Tidak mudah", "Kurang mudah", "Mudah", "Sangat mudah"],
        required: true
      },
      {
        q: "Bagaimana pendapat Saudara tentang kecepatan waktu dalam memberikan pelayanan?",
        img: "3.svg",
        options: ["Tidak cepat", "Kurang cepat", "Cepat", "Sangat cepat"],
        required: true
      },
      {
        q: "Bagaimana pendapat Saudara tentang kewajaran biaya/tarif dalam pelayanan?",
        img: "4.svg",
        options: ["Sangat mahal", "Cukup mahal", "Murah", "Gratis/Sesuai ketentuan"],
        required: true
      },
      {
        q: "Bagaimana pendapat Saudara tentang kesesuaian produk pelayanan dengan hasil yang diberikan?",
        img: "5.svg",
        options: ["Tidak sesuai", "Kurang sesuai", "Sesuai", "Sangat sesuai"],
        required: true
      },
      {
        q: "Bagaimana pendapat Saudara tentang kompetensi petugas dalam pelayanan?",
        img: "6.svg",
        options: ["Tidak kompeten", "Kurang kompeten", "Kompeten", "Sangat kompeten"],
        required: true
      },
      {
        q: "Bagaimana perilaku petugas dalam pelayanan terkait kesopanan dan keramahan?",
        img: "7.svg",
        options: ["Tidak sopan dan ramah", "Kurang sopan dan ramah", "Sopan dan ramah", "Sangat sopan dan ramah"],
        required: true
      },
      {
        q: "Bagaimana penanganan pengaduan pengguna layanan?",
        img: "8.svg",
        options: ["Tidak ada", "Ada tetapi tidak berfungsi", "Kurang maksimal", "Dikelola dengan baik"],
        required: true
      },
      {
        q: "Bagaimana kualitas sarana dan prasarana?",
        img: "9.svg",
        options: ["Buruk", "Cukup", "Baik", "Sangat Baik"],
        required: true
      },
      {
        q: "Bagaimana transparansi pelayanan yang diberikan?",
        img: "10.svg",
        options: ["Standar Pelayanan Tidak dipublikasikan", "Standar pelayanan dipublikasikan sebagian", "Standar pelayanan dipublikasikan seluruhnya", "Standar pelayanan dipublikasikan seluruhnya dan jelas"],
        required: true
      },
      {
        q: "Bagaimana integritas petugas dalam pelayanan?",
        img: "11.svg",
        options: [
          "Petugas pelayanan memberikan pelayanan yang tidak sesuai dengan standar pelayanan yang telah ditetapkan", 
          "Petugas pelayanan memberikan pelayanan dengan cepat, namun disertai dengan permintaan imbalan yang tidak sesuai dengan etika dan integritas profesi", 
          "Petugas pelayanan memberikan pelayanan yang sesuai dengan Standar pelayanan yang telah ditetapkan, menunjukan kepatuhan terhadap prosedur dan prinsip integritas", 
          "Petugas pelayanan memberikan pelayanan yang sesuai dengan Standar pelayanan, serta melaksanakannya dengan cepat dan efisien, tanpa melangal integritas dan etika kerja"
        ],
        required: true
      },
      // {
      //   q: "Kelebihan Pelayanan:",
      //   img: "12.svg",
      //   textarea: true,
      //   required: true
      // },
      // {
      //   q: "Kekurangan Pelayanan:",
      //   img: "13.svg",
      //   textarea: true,
      //   required: true
      // },
      {
        q: "Saran dan masukan Anda:",
        img: "14.svg",
        textarea: true,
        required: false
      }
    ];

    const surveySteps = document.getElementById('surveySteps');

    // Tampilkan catatan "* wajib diisi"
    surveySteps.insertAdjacentHTML("beforebegin", `
     
    `);
    // surveySteps.insertAdjacentHTML("beforebegin", `
    //   <p style="font-size: 0.9em; color: #777; margin-top: 20px;">
    //     <span style="color:red">*</span> Wajib diisi
    //   </p>
    // `);

    questions.forEach((item, index) => {
      const stepDiv = document.createElement('div');
      stepDiv.className = 'survey-step';
      stepDiv.innerHTML = `
        <h5 class="question-title">
          ${index + 1}. ${item.q} ${item.required ? '<span style="color:red">*</span>' : ''}
        </h5>
        <img class="question-img" src="<?php echo $URL;?>/images/icon/${item.img}" alt="Pertanyaan ${index + 1}">
        ${
          item.textarea
            ? `<div class="input-field"><textarea id="textarea${index}" class="materialize-textarea"></textarea></div>`
            : item.options
                .map(
                  (opt, i) => `
          <label>
            <input class="with-gap" type="radio" name="q${index + 1}" value="${String.fromCharCode(97 + i)}" />
            <span>${opt}</span>
          </label><br>
        `).join('')
        }
        <div class="navigation-buttons">
          <button class="btn grey" onclick="prevStep()">Sebelumnya</button>
          <button class="btn blue darken-3" onclick="nextStep()">${index === questions.length - 1 ? 'Kirim' : 'Berikutnya'}</button>
        </div>
      `;
      surveySteps.appendChild(stepDiv);
    });

    let currentStep = 0;
    const steps = document.querySelectorAll('.survey-step');

    function showStep(index) {
      steps.forEach((s, i) => s.classList.toggle('active', i === index));
      document.getElementById('progressBar').style.width = `${(index) / (steps.length - 1) * 100}%`;
    }

    function nextStep() {
      if (currentStep === 0) {
        const nama = document.getElementById('nama').value;
        const umur = document.getElementById('umur').value;
        const hp = document.getElementById('hp').value;
        const gender = document.getElementById('gender').value;

        if (!nama || !umur || !hp || !gender) {
          Swal.fire({
            icon: 'warning',
            title: 'Data belum lengkap',
            text: 'Harap lengkapi semua data responden.',
          });
          return;
        }

        answers[0] = { nama, umur, hp, gender };
      } else {
        const currentQuestion = questions[currentStep - 1];
        const isRequired = currentQuestion.required ?? false;

        if (currentQuestion.textarea) {
          const textarea = document.getElementById(`textarea${currentStep - 1}`);
          const value = textarea.value.trim();

          if (isRequired && !value) {
            Swal.fire({
              icon: 'warning',
              title: 'Jawaban belum diisi',
              text: 'Silakan isi kolom tersebut sebelum melanjutkan.',
            });
            return;
          }

          answers[currentStep] = value; // Simpan walau kosong
        } else {
          const radios = steps[currentStep].querySelectorAll('input[type=radio]');
          const selected = Array.from(radios).find(r => r.checked);

          if (isRequired && !selected) {
            Swal.fire({
              icon: 'warning',
              title: 'Pertanyaan belum dijawab',
              text: 'Pilih salah satu jawaban sebelum melanjutkan.',
            });
            return;
          }

          answers[currentStep] = selected ? answerValues[selected.value] : null;
        }
      }
      console.log(answers);
      // Kirim data kalau sudah di akhir
      if (currentStep === questions.length) {
        Swal.fire({
          title: 'Mengirim data...',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });

        const formData = new FormData();
        formData.append('answers', JSON.stringify(answers));

        fetch("<?php echo $URL;?>/API/saveSurvei", {
          method: "POST",
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          console.log(data);
          if (data.response_status == 'true')
            Swal.fire({
              icon: 'success',
              title: 'Terima kasih!',
              text: 'Data berhasil dikirim.'
            }).then(() => {
              showStep(currentStep + 1);
            });
          else
            Swal.fire({
              icon: 'error',
              title: 'Gagal mengirim',
              text: 'Terjadi kesalahan saat mengirim data.'
            });
        })
        .catch(err => {
          console.error(err);
          Swal.fire({
            icon: 'error',
            title: 'Gagal mengirim',
            text: 'Terjadi kesalahan saat mengirim data.'
          });
        });

        return;
      }

      if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
      }
    }
    

    function prevStep() {
      if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
      }
    }

    showStep(currentStep);
  </script>