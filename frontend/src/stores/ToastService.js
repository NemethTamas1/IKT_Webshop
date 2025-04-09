import { toast } from "vue3-toastify";

export const ToastService = {
  showError(message = "Hiba a szinkronizálás során!", duration = 5000) {
    return toast.error(message, {
      autoClose: duration,
      icon: "❌",
      position: "top-right",
    });
  },

  showSuccess(
    message = "Szinkronizálás sikeresen végrehajtva!",
    duration = 3000
  ) {
    return toast.success(message, {
      autoClose: duration,
      icon: "✅",
      position: "top-right",
    });
  },

  showLoading(message = "Betöltés folyamatban...") {
    return toast.loading(message, {
      position: "top-right",
      autoClose: false,
      closeOnClick: false,
      draggable: false,
      type:toast.TYPE.INFO,
    });
  },
  updateToast(toastId, options) {
    toast.update(toastId, options);
  },

  updateToSuccess(toastId, message = "Sikeres művelet!") {
    toast.update(toastId, {
      render: message,
      type: toast.TYPE.SUCCESS,
      icon: "✅",
      autoClose: 3000,
      isLoading: false,
    });
  },

  updateToError(toastId, message = "Hiba történt!") {
    toast.update(toastId, {
      render: message,
      type: toast.TYPE.ERROR,
      icon: "❌",
      autoClose: 5000,
      isLoading: false,
    });
  },

  dismiss(toastId) {
    toast.dismiss(toastId);
  },
};
export const useToast = () => {
  const showLoadingToast = (message = "Betöltés folyamatban...") => {
    return ToastService.showLoading(message);
  };

  const updateToSuccess = (toastId, message = "Sikeres művelet!") => {
    ToastService.updateToSuccess(toastId, message);
  };

  const updateToError = (toastId, message = "Hiba történt!") => {
    ToastService.updateToError(toastId, message);
  };

  return {
    showLoadingToast,
    updateToSuccess,
    updateToError,
  };
};