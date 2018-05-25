function resizeImage(src, w, h, callback) {
	var canvas = document.createElement("canvas"),
		ctx = canvas.getContext("2d"),
		im = new Image();
	w = w || 0,
		h = h || 0;
	im.onload = function() {
		//为传入缩放尺寸用原尺寸
		!w && (w = this.width);
		!h && (h = this.height);
		//以长宽最大值作为最终生成图片的依据
		if(w !== this.width || h !== this.height) {
			var ratio;
			if(w > h) {
				ratio = this.width / w;
				h = this.height / ratio;
			} else if(w === h) {
				if(this.width > this.height) {
					ratio = this.width / w;
					h = this.height / ratio;
				} else {
					ratio = this.height / h;
					w = this.width / ratio;
				}
			} else {
				ratio = this.height / h;
				w = this.width / ratio;
			}
		}
		//以传入的长宽作为最终生成图片的尺寸
		if(w > h) {
			var offset = (w - h) / 2;
			// canvas.width = canvas.height = w;
			canvas.width = w;
			canvas.height = h;
			ctx.drawImage(im, 0, offset, w, h);
		} else if(w < h) {
			var offset = (h - w) / 2;
			// canvas.width = canvas.height = h;
			canvas.width = w;
			canvas.height = h;
			ctx.drawImage(im, offset, 0, w, h);
		} else {
			// canvas.width = canvas.height = h;
			canvas.width = w;
			canvas.height = h;
			ctx.drawImage(im, 0, 0, w, h);
		}
		// 1） 使用 canvas 生成图片内容
		var dataURL=canvas.toDataURL("image/png");
		var arr=dataURL.split(','),
		mime=arr[0].match(/:(.*?);/)[1],
		bstr=atob(arr[1]),
		n=bstr.length,
		u8arr=new Uint8Array(n);
		while(n--){
			u8arr[n]=bstr.charCodeAt(n);
		}
		// 5) 使用 ArrayBuffer 对象生成  Blob
		var obj=new Blob([u8arr],{type:mime});
		 // 6) 构造 Formdata，准备上传 Blob
		 //创建formdata对象，formData用来存储表单的数据，表单数据时以键值对形式存储的。
		var fd=new FormData();
		// 7) 将 Blob 对象加入 form data 中，注意属性的名称与 server 端的变量名称一致
		fd.append("file",obj,"image.png")
		callback(fd,dataURL);
	}
	im.src = src;
}