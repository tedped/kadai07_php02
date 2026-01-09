/* =========
  ウィザード制御
========= */
const state = {
  date: "",
  amount: "",
  major: "",
  sub: "",
  detail: "",
  payment: "",
  memo: "",
};

const cards = [...document.querySelectorAll(".card")];
let currentIndex = 0;

const showCard = (index) => {
  cards.forEach((card, i) => {
    card.classList.toggle("active", i === index);
  });
};

document.addEventListener("click", (e) => {
  if (!e.target.matches("[data-next]")) return;

  const active = document.querySelector(".card.active");
  const step = active.dataset.step;

  switch (step) {
    case "date":
      state.date = document.getElementById("date").value;
      break;
    case "amount":
      state.amount = document.getElementById("amount").value;
      break;
    case "category":
      state.major = majorSelect.value;
      state.sub = subSelect.value;
      state.detail = detailSelect.value;
      break;
    case "payment":
      state.payment = document.getElementById("payment").value;
      break;
    case "memo":
      state.memo = document.getElementById("memo").value;
      break;
  }

  currentIndex++;
  showCard(currentIndex);

  // confirm に来た瞬間に描画
  if (cards[currentIndex].dataset.step === "confirm") {
    renderConfirm();
  }
});

document.querySelector("[data-submit]").addEventListener("click", () => {
  const form = document.getElementById("finalForm");

  // 既存 hidden input があれば値を更新
  form.querySelector('[name="date"]').value = state.date;
  form.querySelector('[name="amount"]').value = state.amount;

  let catInput = form.querySelector('[name="category_id"]');
  if (!catInput) {
    catInput = document.createElement("input");
    catInput.type = "hidden";
    catInput.name = "category_id";
    form.appendChild(catInput);
  }
  catInput.value = state.detail || state.sub || state.major;

  let payInput = form.querySelector('[name="payment"]');
  if (!payInput) {
    payInput = document.createElement("input");
    payInput.type = "hidden";
    payInput.name = "payment";
    form.appendChild(payInput);
  }
  payInput.value = state.payment;

  let memoInput = form.querySelector('[name="memo"]');
  if (!memoInput) {
    memoInput = document.createElement("input");
    memoInput.type = "hidden";
    memoInput.name = "memo";
    form.appendChild(memoInput);
  }
  memoInput.value = state.memo;

  form.submit();
});

/* =========
  カテゴリ select（最低限）
========= */

console.log("categories:", categories);

const majorSelect = document.getElementById("majorSelect");
const subSelect = document.getElementById("subSelect");
const detailSelect = document.getElementById("detailSelect");

const byParent = {};

categories.forEach((c) => {
  const key = c.parent_id == null ? "root" : String(c.parent_id);
  if (!byParent[key]) byParent[key] = [];
  byParent[key].push(c);
});

console.log("root categories:", byParent["root"]);

// 大分類
(byParent["root"] || []).forEach((c) => {
  majorSelect.appendChild(new Option(c.name, c.id));
});

// 中分類
majorSelect.addEventListener("change", () => {
  subSelect.textContent = "";
  detailSelect.textContent = "";

  const subs = byParent[String(majorSelect.value)];
  if (!subs) return;

  subs.forEach((c) => subSelect.appendChild(new Option(c.name, c.id)));
});

// 小分類
subSelect.addEventListener("change", () => {
  detailSelect.textContent = "";

  const details = byParent[String(subSelect.value)];
  if (!details) return;

  details.forEach((c) => detailSelect.appendChild(new Option(c.name, c.id)));
});

const confirmList = document.getElementById("confirmList");

const getCategoryLabel = (id) => {
  const c = categories.find((c) => String(c.id) === String(id));
  return c ? c.name : "";
};

const renderConfirm = () => {
  confirmList.innerHTML = `
    <li>
      日付：
      <input type="date" value="${state.date}" data-key="date">
    </li>
    <li>
      金額：
      <input type="number" value="${state.amount}" data-key="amount">
    </li>
    <li>
      大分類：
      <input type="text" value="${getCategoryLabel(
        state.major
      )}" data-key="major" readonly>
    </li>
    <li>
      中分類：
      <input type="text" value="${getCategoryLabel(
        state.sub
      )}" data-key="sub" readonly>
    </li>
    <li>
      決済手段：
      <input type="text" value="${state.payment}" data-key="payment" readonly>
    </li>
    <li>
      メモ：
      <input type="text" value="${state.memo}" data-key="memo">
    </li>
  `;
};

// 編集反映
confirmList.addEventListener("input", (e) => {
  if (!e.target.dataset.key) return;
  state[e.target.dataset.key] = e.target.value;
});
