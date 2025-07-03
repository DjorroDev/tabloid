 <!-- Modal Save as Template -->
 <div class="modal fade" id="modalSimpanTemplate" tabindex="-1" aria-labelledby="modalSimpanTemplateLabel"
     aria-hidden="true">
     <div class="modal-dialog  modal-dialog-centered">
         <form id="form-save-template" class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalSimpanTemplateLabel">Simpan Halaman Sebagai Template</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
             </div>
             <div class="modal-body">
                 <input type="text" id="input-template-name" class="form-control" placeholder="Nama Template"
                     required>
             </div>
             <div class="modal-footer">
                 <button type="submit" class="btn btn-primary">Simpan</button>
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
             </div>
         </form>
     </div>
 </div>

 <!-- Modal Gabungan Upload & Pilih Gambar -->
 <div class="modal fade" id="modalGambar" tabindex="-1" aria-labelledby="modalGambarLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalGambarLabel">Upload atau Pilih Gambar</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
             </div>
             <div class="modal-body">
                 <form id="form-upload-gambar" class="mb-3" enctype="multipart/form-data">
                     @csrf
                     <div class="input-group">
                         <input type="file" name="image" id="input-upload-gambar" class="form-control"
                             accept="image/*" required>
                         <button type="submit" class="btn btn-primary">Upload</button>
                     </div>
                     <div id="upload-gambar-error" class="text-danger mt-1" style="font-size:0.95em;"></div>
                 </form>
                 <hr>
                 <i class="bi bi-info-circle"></i>
                 <div class="mb-2 text-muted" style="font-size:0.95em;">
                     Tarik gambar untuk drop ke layout / Klik gambar untuk perbarui
                 </div>
                 <div id="daftar-gambar" class="row g-2">
                     <!-- Daftar gambar akan diisi via JS -->
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal Import Data -->
 <div class="modal fade" id="modalImportData" tabindex="-1" aria-labelledby="modalImportDataLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <form id="form-import-data" class="modal-content" enctype="multipart/form-data">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalImportDataLabel">Import Data Artikel & Gambar</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
             </div>
             <div class="modal-body">
                 <div class="mb-2">
                     <label for="input-import-artikel" class="form-label">File Artikel (JSON/CSV)</label>
                     <input type="file" name="artikel" id="input-import-artikel" class="form-control"
                         accept=".json,.csv" required>
                 </div>
                 <div class="mb-2">
                     <label for="input-import-gambar" class="form-label">File Gambar (ZIP, optional)</label>
                     <input type="file" name="gambar_zip" id="input-import-gambar" class="form-control"
                         accept=".zip">
                 </div>
                 <div id="import-data-error" class="text-danger mt-1" style="font-size:0.95em;"></div>
             </div>
             <div class="modal-footer">
                 <button type="submit" class="btn btn-primary">Import</button>
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
             </div>
         </form>
     </div>
 </div>
