(self["webpackChunk"] = self["webpackChunk"] || []).push([["theme-switcher"],{

/***/ "./assets/js/theme-switcher.js":
/*!*************************************!*\
  !*** ./assets/js/theme-switcher.js ***!
  \*************************************/
/***/ (() => {

var checkbox = document.querySelector("input[name=theme_switch]");
if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
  document.documentElement.setAttribute("data-theme", "dark");
  checkbox.checked = true;
  console.log('dark theme toggled');
} else {
  document.documentElement.setAttribute("data-theme", "light");
  checkbox.checked = false;
  console.log('light theme toggled');
}
checkbox.addEventListener("change", function (cb) {
  document.documentElement.setAttribute("data-theme", cb.target.checked ? "dark" : "light");
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ var __webpack_exports__ = (__webpack_exec__("./assets/js/theme-switcher.js"));
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoidGhlbWUtc3dpdGNoZXIuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7QUFBQSxJQUFJQSxRQUFRLEdBQUdDLFFBQVEsQ0FBQ0MsYUFBYSxDQUFDLDBCQUEwQixDQUFDO0FBRWpFLElBQUlDLE1BQU0sQ0FBQ0MsVUFBVSxDQUFDLDhCQUE4QixDQUFDLENBQUNDLE9BQU8sRUFBRTtFQUMzREosUUFBUSxDQUFDSyxlQUFlLENBQUNDLFlBQVksQ0FBQyxZQUFZLEVBQUUsTUFBTSxDQUFDO0VBQzNEUCxRQUFRLENBQUNRLE9BQU8sR0FBRyxJQUFJO0VBQ3ZCQyxPQUFPLENBQUNDLEdBQUcsQ0FBQyxvQkFBb0IsQ0FBQztBQUNyQyxDQUFDLE1BQU07RUFDSFQsUUFBUSxDQUFDSyxlQUFlLENBQUNDLFlBQVksQ0FBQyxZQUFZLEVBQUUsT0FBTyxDQUFDO0VBQzVEUCxRQUFRLENBQUNRLE9BQU8sR0FBRyxLQUFLO0VBQ3hCQyxPQUFPLENBQUNDLEdBQUcsQ0FBQyxxQkFBcUIsQ0FBQztBQUN0QztBQUVBVixRQUFRLENBQUNXLGdCQUFnQixDQUFDLFFBQVEsRUFBRSxVQUFDQyxFQUFFLEVBQUs7RUFDeENYLFFBQVEsQ0FBQ0ssZUFBZSxDQUFDQyxZQUFZLENBQ2pDLFlBQVksRUFDWkssRUFBRSxDQUFDQyxNQUFNLENBQUNMLE9BQU8sR0FBRyxNQUFNLEdBQUcsT0FDakMsQ0FBQztBQUNMLENBQUMsQ0FBQyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL2Fzc2V0cy9qcy90aGVtZS1zd2l0Y2hlci5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyJsZXQgY2hlY2tib3ggPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKFwiaW5wdXRbbmFtZT10aGVtZV9zd2l0Y2hdXCIpO1xuXG5pZiAod2luZG93Lm1hdGNoTWVkaWEoXCIocHJlZmVycy1jb2xvci1zY2hlbWU6IGRhcmspXCIpLm1hdGNoZXMpIHtcbiAgICBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuc2V0QXR0cmlidXRlKFwiZGF0YS10aGVtZVwiLCBcImRhcmtcIik7XG4gICAgY2hlY2tib3guY2hlY2tlZCA9IHRydWU7XG4gICAgY29uc29sZS5sb2coJ2RhcmsgdGhlbWUgdG9nZ2xlZCcpO1xufSBlbHNlIHtcbiAgICBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuc2V0QXR0cmlidXRlKFwiZGF0YS10aGVtZVwiLCBcImxpZ2h0XCIpO1xuICAgIGNoZWNrYm94LmNoZWNrZWQgPSBmYWxzZTtcbiAgICBjb25zb2xlLmxvZygnbGlnaHQgdGhlbWUgdG9nZ2xlZCcpO1xufVxuXG5jaGVja2JveC5hZGRFdmVudExpc3RlbmVyKFwiY2hhbmdlXCIsIChjYikgPT4ge1xuICAgIGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zZXRBdHRyaWJ1dGUoXG4gICAgICAgIFwiZGF0YS10aGVtZVwiLFxuICAgICAgICBjYi50YXJnZXQuY2hlY2tlZCA/IFwiZGFya1wiIDogXCJsaWdodFwiXG4gICAgKTtcbn0pO1xuIl0sIm5hbWVzIjpbImNoZWNrYm94IiwiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yIiwid2luZG93IiwibWF0Y2hNZWRpYSIsIm1hdGNoZXMiLCJkb2N1bWVudEVsZW1lbnQiLCJzZXRBdHRyaWJ1dGUiLCJjaGVja2VkIiwiY29uc29sZSIsImxvZyIsImFkZEV2ZW50TGlzdGVuZXIiLCJjYiIsInRhcmdldCJdLCJzb3VyY2VSb290IjoiIn0=