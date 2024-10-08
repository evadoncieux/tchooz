(self["webpackChunk"] = self["webpackChunk"] || []).push([["theme-switcher"],{

/***/ "./assets/js/theme-switcher.js":
/*!*************************************!*\
  !*** ./assets/js/theme-switcher.js ***!
  \*************************************/
/***/ (() => {

// noinspection DuplicatedCode

var checkbox = document.querySelector("input[name=theme_switch]");
if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
  document.documentElement.setAttribute("data-theme", "dark");
  checkbox.checked = true;
  console.log('1');
} else {
  document.documentElement.setAttribute("data-theme", "light");
  checkbox.checked = false;
  console.log('0');
}

// switch theme if checkbox is engaged

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoidGhlbWUtc3dpdGNoZXIuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7QUFBQTs7QUFFQSxJQUFJQSxRQUFRLEdBQUdDLFFBQVEsQ0FBQ0MsYUFBYSxDQUFDLDBCQUEwQixDQUFDO0FBRWpFLElBQUlDLE1BQU0sQ0FBQ0MsVUFBVSxDQUFDLDhCQUE4QixDQUFDLENBQUNDLE9BQU8sRUFBRTtFQUMzREosUUFBUSxDQUFDSyxlQUFlLENBQUNDLFlBQVksQ0FBQyxZQUFZLEVBQUUsTUFBTSxDQUFDO0VBQzNEUCxRQUFRLENBQUNRLE9BQU8sR0FBRyxJQUFJO0VBQ3ZCQyxPQUFPLENBQUNDLEdBQUcsQ0FBQyxHQUFHLENBQUM7QUFDcEIsQ0FBQyxNQUFNO0VBQ0hULFFBQVEsQ0FBQ0ssZUFBZSxDQUFDQyxZQUFZLENBQUMsWUFBWSxFQUFFLE9BQU8sQ0FBQztFQUM1RFAsUUFBUSxDQUFDUSxPQUFPLEdBQUcsS0FBSztFQUN4QkMsT0FBTyxDQUFDQyxHQUFHLENBQUMsR0FBRyxDQUFDO0FBQ3BCOztBQUVBOztBQUVBVixRQUFRLENBQUNXLGdCQUFnQixDQUFDLFFBQVEsRUFBRSxVQUFDQyxFQUFFLEVBQUs7RUFDeENYLFFBQVEsQ0FBQ0ssZUFBZSxDQUFDQyxZQUFZLENBQ2pDLFlBQVksRUFDWkssRUFBRSxDQUFDQyxNQUFNLENBQUNMLE9BQU8sR0FBRyxNQUFNLEdBQUcsT0FDakMsQ0FBQztBQUNMLENBQUMsQ0FBQyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL2Fzc2V0cy9qcy90aGVtZS1zd2l0Y2hlci5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvLyBub2luc3BlY3Rpb24gRHVwbGljYXRlZENvZGVcblxubGV0IGNoZWNrYm94ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcImlucHV0W25hbWU9dGhlbWVfc3dpdGNoXVwiKTtcblxuaWYgKHdpbmRvdy5tYXRjaE1lZGlhKFwiKHByZWZlcnMtY29sb3Itc2NoZW1lOiBkYXJrKVwiKS5tYXRjaGVzKSB7XG4gICAgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LnNldEF0dHJpYnV0ZShcImRhdGEtdGhlbWVcIiwgXCJkYXJrXCIpO1xuICAgIGNoZWNrYm94LmNoZWNrZWQgPSB0cnVlO1xuICAgIGNvbnNvbGUubG9nKCcxJyk7XG59IGVsc2Uge1xuICAgIGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zZXRBdHRyaWJ1dGUoXCJkYXRhLXRoZW1lXCIsIFwibGlnaHRcIik7XG4gICAgY2hlY2tib3guY2hlY2tlZCA9IGZhbHNlO1xuICAgIGNvbnNvbGUubG9nKCcwJyk7XG59XG5cbi8vIHN3aXRjaCB0aGVtZSBpZiBjaGVja2JveCBpcyBlbmdhZ2VkXG5cbmNoZWNrYm94LmFkZEV2ZW50TGlzdGVuZXIoXCJjaGFuZ2VcIiwgKGNiKSA9PiB7XG4gICAgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LnNldEF0dHJpYnV0ZShcbiAgICAgICAgXCJkYXRhLXRoZW1lXCIsXG4gICAgICAgIGNiLnRhcmdldC5jaGVja2VkID8gXCJkYXJrXCIgOiBcImxpZ2h0XCJcbiAgICApO1xufSk7Il0sIm5hbWVzIjpbImNoZWNrYm94IiwiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yIiwid2luZG93IiwibWF0Y2hNZWRpYSIsIm1hdGNoZXMiLCJkb2N1bWVudEVsZW1lbnQiLCJzZXRBdHRyaWJ1dGUiLCJjaGVja2VkIiwiY29uc29sZSIsImxvZyIsImFkZEV2ZW50TGlzdGVuZXIiLCJjYiIsInRhcmdldCJdLCJzb3VyY2VSb290IjoiIn0=