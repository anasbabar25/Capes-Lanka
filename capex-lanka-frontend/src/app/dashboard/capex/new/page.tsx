"use client";

import { FormEvent, useEffect, useMemo, useState } from "react";
import { useRouter } from "next/navigation";
import Dropdown, { type DropdownOption } from "@/components/ui/Dropdown";
import DateInput from "@/components/ui/DateInput";
import FormInput, { fieldClass } from "@/components/ui/FormInput";
import {
  BUDGETED_OPTIONS,
  CATEGORY_OPTIONS,
  REPLACEMENT_EXPANSION_OPTIONS,
  YES_NO_OPTIONS,
} from "@/lib/capex-form-options";
import { apiFetch } from "@/lib/api";
import { getStoredUser } from "@/lib/auth";
import { canCreateCapex, formatMoney } from "@/lib/roles";
import type { Budget } from "@/types/budget";

const gridClass = "grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4";

function moneyNumber(value: string) {
  const amount = parseFloat(value);
  return Number.isFinite(amount) ? amount : 0;
}

export default function NewCapexPage() {
  const router = useRouter();
  const user = getStoredUser();
  const [budgets, setBudgets] = useState<Budget[]>([]);
  const [costCenter, setCostCenter] = useState("");
  const [budgeted, setBudgeted] = useState("yes");
  const [primaryBudgetLineId, setPrimaryBudgetLineId] = useState("");
  const [extraBudgetIds, setExtraBudgetIds] = useState<string[]>(["", ""]);
  const [expectedCompletionDate, setExpectedCompletionDate] = useState("");
  const [replacementExpansion, setReplacementExpansion] = useState("");
  const [category, setCategory] = useState("");
  const [detailOfProposal, setDetailOfProposal] = useState("");
  const [desiredAssetNameSap, setDesiredAssetNameSap] = useState("");
  const [inHouseAvailability, setInHouseAvailability] = useState("");
  const [enteredByEmail, setEnteredByEmail] = useState(user?.email ?? "");
  const [extensionNumber, setExtensionNumber] = useState("");
  const [localCost, setLocalCost] = useState("");
  const [importedCost, setImportedCost] = useState("");
  const [currencyCode, setCurrencyCode] = useState("");
  const [foreignCurrencyAmount, setForeignCurrencyAmount] = useState("");
  const [exchangeRate, setExchangeRate] = useState("");
  const [localCustomsDuty, setLocalCustomsDuty] = useState("");
  const [importedCustomsDuty, setImportedCustomsDuty] = useState("");
  const [localOtherCost, setLocalOtherCost] = useState("");
  const [importedOtherCost, setImportedOtherCost] = useState("");
  const [localGst, setLocalGst] = useState("");
  const [importedGst, setImportedGst] = useState("");
  const [error, setError] = useState("");
  const [isLoading, setIsLoading] = useState(false);

  const showBudgetReference = budgeted === "yes" || budgeted === "strategic";
  const plantAndMachinery = category === "plant-and-machinery";
  const allowsVirement = Boolean(user?.department?.allowsBudgetVirement);
  const allowsUnbudgeted = Boolean(user?.department?.allowsUnbudgetedRequests);

  const budgetedOptions = BUDGETED_OPTIONS.filter(
    (option) => option.value !== "no" || allowsUnbudgeted,
  );

  const totalAmount =
    moneyNumber(localCost) +
    moneyNumber(importedCost) +
    moneyNumber(localCustomsDuty) +
    moneyNumber(importedCustomsDuty) +
    moneyNumber(localOtherCost) +
    moneyNumber(importedOtherCost) +
    (plantAndMachinery ? 0 : moneyNumber(localGst) + moneyNumber(importedGst));

  const budgetOptions: DropdownOption[] = useMemo(
    () =>
      budgets.map((budget) => ({
        value: String(budget.id),
        label: `${budget.referenceCode} — ${budget.description} (Remaining ${formatMoney(budget.remainingAmount)})`,
      })),
    [budgets],
  );

  useEffect(() => {
    if (!user || !canCreateCapex(user.role)) {
      router.replace("/dashboard/capex");
    }
  }, [router, user]);

  useEffect(() => {
    if (!showBudgetReference) {
      setBudgets([]);
      return;
    }
    const type = budgeted === "strategic" ? "strategic" : "annual";
    apiFetch<Budget[]>(`/budgets/available?type=${type}`)
      .then(setBudgets)
      .catch(() => setBudgets([]));
  }, [budgeted, showBudgetReference]);

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setError("");
    setIsLoading(true);

    const additionalBudgetLineIds = extraBudgetIds
      .map((value) => Number(value))
      .filter((value) => Number.isInteger(value) && value > 0);

    try {
      await apiFetch("/capex", {
        method: "POST",
        body: JSON.stringify({
          costCenter,
          budgeted,
          ...(showBudgetReference && primaryBudgetLineId
            ? { primaryBudgetLineId: Number(primaryBudgetLineId) }
            : {}),
          additionalBudgetLineIds,
          expectedCompletionDate,
          replacementExpansion,
          category,
          detailOfProposal,
          desiredAssetNameSap,
          inHouseAvailability,
          enteredByEmail,
          extensionNumber,
          localCost: moneyNumber(localCost),
          importedCost: moneyNumber(importedCost),
          currencyCode: currencyCode || undefined,
          foreignCurrencyAmount: moneyNumber(foreignCurrencyAmount),
          exchangeRate: moneyNumber(exchangeRate),
          localCustomsDuty: moneyNumber(localCustomsDuty),
          importedCustomsDuty: moneyNumber(importedCustomsDuty),
          localOtherCost: moneyNumber(localOtherCost),
          importedOtherCost: moneyNumber(importedOtherCost),
          localGst: plantAndMachinery ? 0 : moneyNumber(localGst),
          importedGst: plantAndMachinery ? 0 : moneyNumber(importedGst),
        }),
      });
      router.push("/dashboard/capex");
    } catch (err) {
      setError(err instanceof Error ? err.message : "Failed to create capex");
    } finally {
      setIsLoading(false);
    }
  }

  return (
    <form
      onSubmit={handleSubmit}
      className="w-full rounded-xl border border-slate-200/80 bg-white shadow-sm"
    >
      {error && (
        <div className="mx-5 mt-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm text-rose-600 lg:mx-6">
          {error}
        </div>
      )}

      <div className={`p-5 lg:p-6 ${gridClass}`}>
        <FormInput
          id="costCenter"
          label="Cost Center"
          value={costCenter}
          onChange={setCostCenter}
          placeholder="CC-1001"
          required
        />
        <FormInput
          id="originatingDepartment"
          label="Originating Department"
          value={user?.department?.name ?? ""}
          onChange={() => undefined}
          readOnly
          required
        />
        <Dropdown
          id="budgeted"
          name="budgeted"
          label="Budgeted"
          placeholder="Select"
          value={budgeted}
          onChange={(value) => {
            setBudgeted(value);
            setPrimaryBudgetLineId("");
            setExtraBudgetIds(["", ""]);
          }}
          options={budgetedOptions}
          required
        />
        {showBudgetReference && (
          <Dropdown
            id="primaryBudgetLineId"
            name="primaryBudgetLineId"
            label="Budget Reference"
            placeholder="Select budget"
            value={primaryBudgetLineId}
            onChange={setPrimaryBudgetLineId}
            options={budgetOptions}
            required
          />
        )}
        {showBudgetReference && allowsVirement &&
          extraBudgetIds.map((value, index) => (
            <Dropdown
              key={`extra-${index}`}
              id={`extraBudget${index}`}
              name={`extraBudget${index}`}
              label={`Adjustment budget ${index + 1}`}
              placeholder="Optional virement line"
              value={value}
              onChange={(next) => {
                setExtraBudgetIds((current) =>
                  current.map((item, itemIndex) =>
                    itemIndex === index ? next : item,
                  ),
                );
              }}
              options={budgetOptions.filter(
                (option) => option.value !== primaryBudgetLineId,
              )}
            />
          ))}
        <DateInput
          id="expectedCompletionDate"
          label="Expected Completion Date"
          value={expectedCompletionDate}
          onChange={setExpectedCompletionDate}
          required
          min={new Date().toISOString().split("T")[0]}
        />
        <Dropdown
          id="replacementExpansion"
          name="replacementExpansion"
          label="Replacement / Expansion"
          placeholder="Select"
          value={replacementExpansion}
          onChange={setReplacementExpansion}
          options={REPLACEMENT_EXPANSION_OPTIONS}
          required
        />
        <Dropdown
          id="category"
          name="category"
          label="Category"
          placeholder="Select category"
          value={category}
          onChange={setCategory}
          options={CATEGORY_OPTIONS}
          required
        />
        <Dropdown
          id="inHouseAvailability"
          name="inHouseAvailability"
          label="In-House Availability"
          placeholder="Select"
          value={inHouseAvailability}
          onChange={setInHouseAvailability}
          options={YES_NO_OPTIONS}
          required
        />
        <FormInput
          id="desiredAssetNameSap"
          label="Desired Asset Name in SAP Register"
          value={desiredAssetNameSap}
          onChange={setDesiredAssetNameSap}
          placeholder="Asset name"
          required
        />
        <FormInput
          id="enteredByEmail"
          label="Entered By (Email)"
          type="email"
          value={enteredByEmail}
          onChange={setEnteredByEmail}
          placeholder="you@company.com"
          required
        />
        <FormInput
          id="extensionNumber"
          label="Ext No"
          value={extensionNumber}
          onChange={setExtensionNumber}
          placeholder="101"
          required
        />
        <div className="space-y-1.5 sm:col-span-2 lg:col-span-3 xl:col-span-4">
          <label
            htmlFor="detailOfProposal"
            className="block text-xs font-medium tracking-wide text-slate-500"
          >
            Detail of Proposal
          </label>
          <textarea
            id="detailOfProposal"
            name="detailOfProposal"
            required
            minLength={10}
            rows={3}
            value={detailOfProposal}
            onChange={(event) => setDetailOfProposal(event.target.value)}
            placeholder="Describe the proposal..."
            className={`${fieldClass} resize-none`}
          />
        </div>
      </div>

      <div className="border-t border-slate-100 px-5 py-4 lg:px-6">
        <h3 className="mb-4 text-sm font-semibold text-slate-800">Cost of Project</h3>
        <div className="overflow-x-auto rounded-lg border border-slate-200">
          <table className="min-w-full text-sm">
            <thead className="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
              <tr>
                <th className="px-3 py-2 text-left">Item</th>
                <th className="px-3 py-2">Local Rs.</th>
                <th className="px-3 py-2">Imported Rs.</th>
                <th className="px-3 py-2">Currency</th>
                <th className="px-3 py-2">FC Amount</th>
                <th className="px-3 py-2">Rate</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td className="px-3 py-2">Cost</td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={localCost} onChange={(e) => setLocalCost(e.target.value)} />
                </td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={importedCost} onChange={(e) => setImportedCost(e.target.value)} />
                </td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={currencyCode} onChange={(e) => setCurrencyCode(e.target.value)} />
                </td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={foreignCurrencyAmount} onChange={(e) => setForeignCurrencyAmount(e.target.value)} />
                </td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={exchangeRate} onChange={(e) => setExchangeRate(e.target.value)} />
                </td>
              </tr>
              <tr>
                <td className="px-3 py-2">Custom Duty</td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={localCustomsDuty} onChange={(e) => setLocalCustomsDuty(e.target.value)} />
                </td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={importedCustomsDuty} onChange={(e) => setImportedCustomsDuty(e.target.value)} />
                </td>
                <td colSpan={3} />
              </tr>
              <tr>
                <td className="px-3 py-2">Others</td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={localOtherCost} onChange={(e) => setLocalOtherCost(e.target.value)} />
                </td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={importedOtherCost} onChange={(e) => setImportedOtherCost(e.target.value)} />
                </td>
                <td colSpan={3} />
              </tr>
              <tr>
                <td className="px-3 py-2">
                  GST {plantAndMachinery ? "(not applicable for Plant & Machinery)" : ""}
                </td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={localGst} onChange={(e) => setLocalGst(e.target.value)} disabled={plantAndMachinery} />
                </td>
                <td className="px-3 py-2">
                  <input className={fieldClass} value={importedGst} onChange={(e) => setImportedGst(e.target.value)} disabled={plantAndMachinery} />
                </td>
                <td colSpan={3} />
              </tr>
            </tbody>
          </table>
        </div>
        <p className="mt-3 text-sm font-semibold text-slate-800">
          Total: {formatMoney(totalAmount)}
        </p>
      </div>

      <div className="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50/50 px-5 py-4 lg:px-6">
        <button
          type="button"
          onClick={() => router.push("/dashboard/capex")}
          className="cursor-pointer rounded-lg px-4 py-2.5 text-sm font-medium text-slate-500 transition-colors hover:bg-white hover:text-slate-700"
        >
          Cancel
        </button>
        <button
          type="submit"
          disabled={isLoading}
          className="cursor-pointer rounded-lg bg-pll-cyan px-5 py-2.5 text-sm font-semibold text-white shadow-[0_4px_16px_-4px_rgba(0,173,239,0.5)] transition-all hover:bg-pll-cyan-dark disabled:cursor-not-allowed disabled:opacity-70"
        >
          {isLoading ? "Submitting..." : "Submit Proposal"}
        </button>
      </div>
    </form>
  );
}
